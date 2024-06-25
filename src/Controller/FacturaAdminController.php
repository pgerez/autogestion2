<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Cuota;
use App\Entity\Factura;
use App\Entity\ItemPrefacturacion;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class FacturaAdminController extends CRUDController{

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
            array(),
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
                    </tr>';
                foreach ($items as $item):
                    $cid = is_array($item->getCuota()) ? $item->getCuota()->getId() : 0;
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
                                <td>'.$item->getPrecio().'</td>
                            </tr>';
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
            $check = $em->getRepository(ItemPrefacturacion::class)->updateCheckItems($checked, $idcuota);
        endif;
        $this->addFlash('sonata_flash_success', 'Los itemas de las facturas asociadas al pago: '.$idpago.' Se guardaron exitosamenete.');
        return $this->redirectToRoute('admin_app_pago_edit',['id' => $idpago]);
    }



}
