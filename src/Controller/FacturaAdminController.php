<?php

declare(strict_types=1);

namespace App\Controller;

use App\Application\ReportBundle\Report\ReportPDF;
use App\Entity\Cuota;
use App\Entity\Factura;
use App\Entity\ItemPrefacturacion;
use Sonata\AdminBundle\Controller\CRUDController;
use Spipu\Html2Pdf\Html2Pdf;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class FacturaAdminController extends CRUDController{

    //------    CONVERTIR NUMEROS A LETRAS         ---------------
    public function numtoletras($xcifra)
    {


        $xarray = array(0 => "Cero",
            1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
            "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
            "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
            100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
        );
        //
        $xcifra = trim($xcifra);
        $xlength = strlen($xcifra);
        $xpos_punto = strpos($xcifra, ".");
        $xaux_int = $xcifra;
        $xdecimales = "00";
        if (!($xpos_punto === false)) {
            if ($xpos_punto == 0) {
                $xcifra = "0" . $xcifra;
                $xpos_punto = strpos($xcifra, ".");
            }
            $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
            $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
        }

        $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
        $xcadena = "";
        for ($xz = 0; $xz < 3; $xz++) {
            $xaux = substr($XAUX, $xz * 6, 6);
            $xi = 0;
            $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
            $xexit = true; // bandera para controlar el ciclo del While
            while ($xexit) {
                if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                    break; // termina el ciclo
                }

                $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
                $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
                for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                    switch ($xy) {
                        case 1: // checa las centenas
                            if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas

                            } else {
                                $key = (int) substr($xaux, 0, 3);
                                if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                    $xseek = $xarray[$key];
                                    $xsub = $this->subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                    if (substr($xaux, 0, 3) == 100)
                                        $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                    $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                                }
                                else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                    $key = (int) substr($xaux, 0, 1) * 100;
                                    $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                } // ENDIF ($xseek)
                            } // ENDIF (substr($xaux, 0, 3) < 100)
                            break;
                        case 2: // checa las decenas (con la misma lógica que las centenas)
                            if (substr($xaux, 1, 2) < 10) {

                            } else {
                                $key = (int) substr($xaux, 1, 2);
                                if (TRUE === array_key_exists($key, $xarray)) {
                                    $xseek = $xarray[$key];
                                    $xsub = $this->subfijo($xaux);
                                    if (substr($xaux, 1, 2) == 20)
                                        $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                    $xy = 3;
                                }
                                else {
                                    $key = (int) substr($xaux, 1, 1) * 10;
                                    $xseek = $xarray[$key];
                                    if (20 == substr($xaux, 1, 1) * 10)
                                        $xcadena = " " . $xcadena . " " . $xseek;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                                } // ENDIF ($xseek)
                            } // ENDIF (substr($xaux, 1, 2) < 10)
                            break;
                        case 3: // checa las unidades
                            if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada

                            } else {
                                $key = (int) substr($xaux, 2, 1);
                                $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                                $xsub = $this->subfijo($xaux);
                                $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                            } // ENDIF (substr($xaux, 2, 1) < 1)
                            break;
                    } // END SWITCH
                } // END FOR
                $xi = $xi + 3;
            } // ENDDO

            if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
                $xcadena.= " DE";

            if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
                $xcadena.= " DE";

            // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
            if (trim($xaux) != "") {
                switch ($xz) {
                    case 0:
                        if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                            $xcadena.= "UN BILLON ";
                        else
                            $xcadena.= " BILLONES ";
                        break;
                    case 1:
                        if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                            $xcadena.= "UN MILLON ";
                        else
                            $xcadena.= " MILLONES ";
                        break;
                    case 2:
                        if ($xcifra < 1) {
                            $xcadena = "CERO PESOS CON $xdecimales/100 ";
                        }
                        if ($xcifra >= 1 && $xcifra < 2) {
                            $xcadena = "UN PESO CON $xdecimales/100 ";
                        }
                        if ($xcifra >= 2) {
                            $xcadena.= " PESOS CON $xdecimales/100 "; //
                        }
                        break;
                } // endswitch ($xz)
            } // ENDIF (trim($xaux) != "")
            // ------------------      en este caso, para México se usa esta leyenda     ----------------
            $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
            $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
            $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
            $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
            $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
            $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
            $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
        } // ENDFOR ($xz)
        return trim($xcadena);
    }

    // END FUNCTION

    public function subfijo($xx)
    { // esta función regresa un subfijo para la cifra
        $xx = trim($xx);
        $xstrlen = strlen($xx);
        if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
            $xsub = "";
        //
        if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
            $xsub = "MIL";
        //
        return $xsub;
    }

    /**
     * @Route(schemes={"https"})
     */
    public function listitemsAction(Request $request) : Response
    {
        $em         = $this->getDoctrine()->getManager();
        $data1      = $request->getContent();
        #$data      = str_replace('"', '', $array->{'dni'});
        $data       = json_decode($data1);
        $idfactura  = $data->idfactura;
        $idpago     = $data->idpago;
        $idcuota    = $data->idcuota;
        $id         = $data->id;
        $items      = $em->getRepository(Factura::class)->find($idfactura)->getItemPrefacturacions();
        $cuota      = $em->getRepository(Cuota::class)->find($idcuota);
        $url        = $this->generateUrl(
            'admin_app_factura_saveitems',
            [],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        $html = '<form action="'.$url.'" method="post" enctype="multipart/form-data">
                <div class="box box-primary">
                <input type="hidden" name="idfactura" value="'.$idfactura.'" />
                <input type="hidden" name="idpago" value="'.$idpago.'" />
                <input type="hidden" name="idcuota" value="'.$idcuota.'" />
                <div class="box-body table-responsive no-padding">
                <table class="table table-bordered table-striped table-hover sonata-ba-list">
                    <tbody>
                    <tr>
                        <td colspan="7" style="text-align: center">Factura: '.$em->getRepository(Factura::class)->find($idfactura)->getNumeroCompleto().'<br> ID:'.$idcuota.'</td>
                    </tr>
                    <tr>
                        <th class="sonata-ba-list-field-header sonata-ba-list-field-header-batch">
                            <div class="icheckbox_square-blue" style="position: relative;">
                                <input type="checkbox" id="list_batch_checkbox" style="position: absolute; opacity: 0;">
                            </div>
                        </th>
                        <th>Anexo</th>
                        <th>Paciente</th>
                        <th>Servicio</th>
                        <th>Practica</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Debito</th>
                    </tr>';
                foreach ($items as $item):
                    $cid = $item->getCuota() ? $item->getCuota()->getId() : 0;
                    $checked = $item->getEstadoPago() == 1 ? 'checked' : '';
                    $html .='<tr>
                                <td class="sonata-ba-list-field sonata-ba-list-field-batch" objectid="'.$item->getId().'">';
                    if($cuota->getLiquidacion() == null):
                        if($cid == $idcuota or $cid == 0):
                            $html .= '<div class="icheckbox_square-blue" style="position: relative;">
                                        <input type="checkbox" '.$checked.' name="idx[]" value="'.$item->getId().'" style="position: absolute; opacity: 0;">
                                      </div>';
                        endif;
                    else:
                        $html .=$cuota->getLiquidacion()->getId();
                    endif;
                    $html .='</td>
                                <td>'.$item->getNumAnexo().'</td>
                                <td>'.$item->getNumAnexo()->getApeynom().'</td>
                                <td>'.$item->getCodservFK()->getDescripcionServicio().'</td>
                                <td>'.$item->getNomencla()->getTema().'</td>
                                <td>'.$item->getCantidad().'</td>
                                <td>'.$item->getPrecio().'</td>';
                    if($cuota->getLiquidacion() == null):
                        $html .='<td><input type="text" name="monto_pago_'.$item->getId().'" id="monto_pago_'.$item->getId().'" value="'.$item->getMontoPago().'" size="5"></td>';
                    else:
                        $html .= '<td>'.$item->getMontoPago().'</td>';
                    endif;

                     $html .='</tr>';
                endforeach;
         $html .= <<<EOF
                 </tbody>
                 </table>
                 </div>
                 </div>
                 <div   class="sonata-ba-form-actions well well-small form-actions">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
                 </form>
                    <script>
                            jQuery(document).ready(function ($) {
                                // Toggle individual checkboxes when the batch checkbox is changed
                                $('#list_batch_checkbox').on('ifChanged change', function () {
                                    var checkboxes = $(this).closest('table').find('td.sonata-ba-list-field-batch input[type="checkbox"], div.sonata-ba-list-field-batch input[type="checkbox"]');
                                    if (Admin.get_config('USE_ICHECK')) {
                                        checkboxes.iCheck($(this).is(':checked') ? 'check' : 'uncheck');
                                    } else {
                                        checkboxes.prop('checked', this.checked);
                                    }
                                });
                                // Add a CSS class to rows when they are selected
                                $('td.sonata-ba-list-field-batch input[type="checkbox"], div.sonata-ba-list-field-batch input[type="checkbox"]').on('ifChanged change', function () {
                                    $(this).closest('tr, div.sonata-ba-list-field-batch').toggleClass('sonata-ba-list-row-selected', $(this).is(':checked'));
                                }).trigger('ifChanged');
                                });
                                Admin.setup_icheck(jQuery('#{$id}'));
                    </script>
                     
EOF;
        return new JsonResponse($html);
    }

    public function saveitemsAction(Request $request) : Response
    {
        $em = $this->getDoctrine()->getManager();
        $idhospital = $request->get('idhospital');
        $idpago = $request->get('idpago');
        $idfactura = $request->get('idfactura');
        $idcuota = $request->get('idcuota');
        $checked = $request->get('idx');
        $montoFact = 0;
        $uncheck = $em->getRepository(ItemPrefacturacion::class)->updateUncheckItems($idfactura, $idcuota);
        if(isset($checked)):
            foreach ($checked as $ch):
                $array[$ch] = $request->get('monto_pago_'.$ch);
            endforeach;
            $check = $em->getRepository(ItemPrefacturacion::class)->updateCheckItems($array, $idcuota);
        endif;
        $this->addFlash('sonata_flash_success', 'Los itemas de las facturas asociadas al pago: '.$idpago.' Se guardaron exitosamenete.');
        return $this->redirectToRoute('admin_app_pago_edit',['id' => $idpago]);
    }

    public function pdfAction(Request $request) : Response
    {

        $factura  = $this->admin->getSubject();
        $fechaCae = $factura->getCaeVto() ? $factura->getCaeVto()->format('d/m/Y') : 'SIN FECHA';
        $pdf = new ReportPDF('P', 'mm', 'LEGAL', true, 'UTF-8', false, false, false,false);       //set document information

        //$pdf = $this->get('white_october.tcpdf')->create();       //set document information

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor(PDF_AUTHOR);
        $pdf->SetTitle('Factura');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        //set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        #$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); //set image scale factor
        $pdf->AddPage();

        $html=<<<EOF
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<style>
    * {
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    body {
        width: 21cm;
        min-height: 27cm;
        max-height: 29.7cm;
        font-size: 13px;
    }

    .wrapper {
        border: 1.5px solid #333;
        padding: 5px;
    }
 
    .text-left {
        text-align: left;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    .bold {
        font-weight: bold;
    }

    .italic {
        font-style: italic;
    }

    .inline-block {
        display: inline-block;
    }

    .flex {
        display: flex;
        flex-wrap: wrap;
        height: auto;
    }

    .no-margin {
        margin: 0;
    }

    .relative {
        position: relative;
    }

    .floating-mid {
        left: 0;
        right: 335px;
        margin-left: auto;
        margin-right: auto;
        width: 75px;
        position: absolute;
        top: 1px;
        background: #fff;
    }
    .floating-left {
        left: 0;
        right: 0;
        margin-left: 670px;
        margin-right: auto;
        width: 400px;
        position: absolute;
        top: 0;
        background: #fff;
        
    }

    .space-around {
        justify-content: space-around;

    .space-between {
        justify-content: space-between;
    }

    .w50 {
        width: 50%;
        height: 170px;
    }

    th {
        border: 1px solid #000;
        background: #ccc;
        padding: 5px;
    }

    td {
        padding: 5px;
        font-size: 11px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        ce
    }

    .text-20 {
        font-size: 20px;
    }
</style>

<body>
    <div class="wrapper text-center bold text-20" style="width:100%;border-bottom: 0;">
        ORIGINAL
    </div>

    <div class="flex relative">
        <div class="wrapper inline-block w50">
            <h3 class="text-center" style="font-size:24px;margin-bottom: 3px">SUBSECRETARIA DE <br> SALUD</h3>
            <p style="font-size: 13px;line-height: 1.5;margin-bottom: 0;align-self: flex-end;">
                <b>Razón Social:</b> SUBSECRETARIA DE SALUD
                <br><b>Domicilio Comercial:</b> Av Belgrano Sud 2050 - Santiago Del Estero, Santiago del Estero
                <br><b>Condición frente al IVA: IVA Sujeto Exento</b>
                <br>
            </p>
        </div>
        <div class="wrapper inline-block w50 floating-left">
            <h3 class="text-center" style="font-size:24px;margin-bottom: 3px;">FACTURA</h3>
            <p style="font-size: 13px;line-height: 1.5;margin-bottom: 0;">
                <b>Punto de Venta: {$factura->getSoloPvCompleto()} Comp. Nro: {$factura->getSoloNumeroCompleto()}</b>
                <br><b>Fecha de Emisión: {$factura->getFechaEmision()->format('d/m/Y')}</b>
                <br><b>CUIT:</b> 30675068441
                <br><b>Ingresos Brutos:</b> 30675068441
                <br><b>Fecha de Inicio de Actividades:</b> 01/05/1994
            </p>
        </div>
        <div class="wrapper floating-mid">
            <h3 class="no-margin text-center" style="font-size: 38px;">C</h3>
            <h5 class="no-margin text-center">COD. 011</h5>
        </div>
    </div>
<br>
    <div class="wrapper flex space-around" style="margin-top: 1px;">
        <span><b>Período Facturado Desde:</b> {$factura->getFechaEmision()->format('d/m/Y')}</span>
        <span><b>Hasta:</b> {$factura->getFechaEmision()->format('d/m/Y')}</span>
        <span><b>Fecha de Vto. para el pago:</b> {$factura->getFechaEmision()->format('d/m/Y')}</span>
    </div>

    <div class="wrapper" style="margin-top: 2px">
        <span>
            <span style="width:20%"><b>CUIT:</b> {$factura->getCodOs()->getCuit()}</span>
            <span><b>Apellido y Nombre / Razón Social:</b> {$factura->getCodOs()->getDenomina()}</span>
        </span>
        <br>
        <span style="flex-wrap: nowrap;">
            <span><b>Condición frente al IVA:</b> IVA Responsable Inscripto</span>
            <span><b>Domicilio:</b> {$factura->getCodOs()->getDomicilio()}</span>
        </span>
        <br>
        <span>
            <span><b>Condición de venta:</b> Otra</span>
        </span>
    </div>
    <div class="wrapper " style="width:100%; margin-top: 10px;padding-left: 0px; border: 0px">
        <table style="margin-left: 0px">
            <thead>
                <tr>
                <th class="text-left">Código</th>
                <th class="text-left" style="width: 34%">Producto / Servicio</th>
                <th>Cantidad</th>
                <th>U. Medida</th>
                <th>Precio Unit.</th>
                <th>% Bonif</th>
                <th>Imp. Bonif.</th>
                <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-left">1</td>
                    <td class="text-left">Texto para obras sociales</td>
                    <td class="text-right">1,00</td>
                    <td class="text-center">otras unidades</td>
                    <td class="text-right">{$factura->getMontoFact()}</td>
                    <td class="text-center">0,00</td>
                    <td class="text-center">0,00</td>
                    <td class="text-right">{$factura->getMontoFact()}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div  style="margin-top: 300px;">
            <div style="width:100%; margin-top: 30px;padding-left: 500px " class="flex wrapper">
               <table>
               <tr>
                   <td><span ><b>Subtotal: $</b></span></td>
                   <td  class="text-right"  style="text-align: right; margin-right: 0;"><span ><b>0,00</b></span></td>
               </tr>
               <tr>
                   <td><span class="text-right" style="text-align: left"><b>Importe Otros Tributos: $</b></span></td>
                   <td><span class="text-right" style="text-align: right"><b>0,00</b></span></td>
               </tr>
               <tr>
                   <td><span class="text-right" style=""><b>Importe Total:  $</b></span></td>
                   <td><span class="text-right" style=""><b>{$factura->getMontoFact()}</b></span></td>
               </tr>
               </table> 
            </div>
            <div class="flex" style="width:100%; height: 20%; margin-top: 10px;padding-left: 500px ">
                <span class="text-right" style="width:50%"><b>CAE N°:</b></span><span class="text-left"
                    style="padding-left: 10px;">{$factura->getCae()}</span><br>
                <span class="text-right" style="width:50%"><b>Fecha de Vto. de CAE:</b></span><span class="text-left"
                    style="padding-left: 10px;">{$fechaCae}</span>
            </div>
    </div>
</body>

</html>
EOF;


        $html2pdf = new Html2Pdf();
        $html2pdf->writeHTML($html);
        $html2pdf->output();

        // output the HTML content
        #$pdf->writeHTML($html, true, false, true, false, '');
        #$pdf->Output('factura'.$factura->getDigitalNum().'-'.$factura->getDigitalPv().'pdf');
        return sfView::NONE;

    }



}
