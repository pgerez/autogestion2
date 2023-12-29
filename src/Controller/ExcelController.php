<?php

namespace App\Controller;

use App\Entity\Factura;
use App\Entity\ObrasSociales;
use App\Entity\Hospital;
use App\Entity\Servicios;
use Afip;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelController extends AbstractController
{
    /**
     * @Route("/excel", name="app_excel")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $hospitals = $em->getRepository('App\Entity\Hospital')->findAll();
        return $this->render('excel/index.html.twig', [
            'controller_name' => 'ExcelController',
            'hospitals' => $hospitals,
        ]);
    }

     /**
     * @Route("/processexcel", name="process_excel")
     * @return Response
     */
    public function excel(Request $request): Response
    {
        $inputFileName = $request->files->get('excelfile');
        $hospitalid = $request->get('hospitalid');

        
        #$helper->log('Loading file ' . pathinfo($inputFileName, PATHINFO_BASENAME) . ' using IOFactory to identify the format');
        $spreadsheet = IOFactory::load($inputFileName);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
		unset($sheetData[1]);
		$sheetData = array_reverse($sheetData);

        $entityManager = $this->getDoctrine()->getManager();
        #$facturaEntityManager = $entityManager(Factura::class);
        $hospital = $entityManager->getRepository(Hospital::class)->find($hospitalid);
        $error = false;
        foreach ($sheetData as $fila):
            if(!$entityManager->getRepository(Factura::class)->findOneBy(['codigo' => $fila['A']])):
                $rnos = $entityManager->getRepository(ObrasSociales::class)->findByRnos($fila['G']);
                if($rnos):
                    $afip = new Afip(array('CUIT' => 23216313194,
                                            'cert' => 'produccion.crt',
                                            'key'=> 'produccion.key',
                                            'res_folder' => dirname(__DIR__).'/Afip_res/',
                                            'ta_folder'  => dirname(__DIR__).'/Afip_res/',
                                            'production' => TRUE,
                                            #'access_token' => 'A90CkOCpcfYF5PuDs3VkrnpUszzndpkddKFm0Dzp4DBBDYx1k8ZBTvkXHdFEwk7v'
                        ));
                //Reemplazar el CUIT
                    /**
                     * Numero del punto de venta
                     **/
                    $punto_de_venta = 112;

                    /**
                     * Tipo de factura
                     **/
                    $tipo_de_comprobante = 11; // 11 = Factura C

                    /**
                     * Número de la ultima Factura C
                     **/
                    $last_voucher = $afip->ElectronicBilling->GetLastVoucher($punto_de_venta, $tipo_de_comprobante);

                    /**
                     * Concepto de la factura
                     *
                     * Opciones:
                     *
                     * 1 = Productos
                     * 2 = Servicios
                     * 3 = Productos y Servicios
                     **/
                    $concepto = 2;

                    /**
                     * Tipo de documento del comprador
                     *
                     * Opciones:
                     *
                     * 80 = CUIT
                     * 86 = CUIL
                     * 96 = DNI
                     * 99 = Consumidor Final
                     **/
                    $tipo_de_documento = 80;

                    /**
                     * Numero de documento del comprador (0 para consumidor final)
                     **/
                    $numero_de_documento = $rnos->getCuit();

                    /**
                     * Numero de comprobante
                     **/
                    $numero_de_factura = $last_voucher+1;

                    /**
                     * Fecha de la factura en formato aaaa-mm-dd (hasta 10 dias antes y 10 dias despues)
                     **/
                    $fecha = date('Y-m-d');

                    /**
                     * Importe de la Factura
                     **/
                    $importe_total = 100;

                    /**
                     * Los siguientes campos solo son obligatorios para los conceptos 2 y 3
                     **/
                    if ($concepto === 2 || $concepto === 3) {
                        /**
                         * Fecha de inicio de servicio en formato aaaammdd
                         **/
                        $fecha_servicio_desde = intval(date('Ymd'));

                        /**
                         * Fecha de fin de servicio en formato aaaammdd
                         **/
                        $fecha_servicio_hasta = intval(date('Ymd'));

                        /**
                         * Fecha de vencimiento del pago en formato aaaammdd
                         **/
                        $fecha_vencimiento_pago = intval(date('Ymd'));
                    }
                    else {
                        $fecha_servicio_desde = null;
                        $fecha_servicio_hasta = null;
                        $fecha_vencimiento_pago = null;
                    }


                    $data = array(
                        'CantReg' 	=> 1, // Cantidad de facturas a registrar
                        'PtoVta' 	=> $punto_de_venta,
                        'CbteTipo' 	=> $tipo_de_comprobante,
                        'Concepto' 	=> $concepto,
                        'DocTipo' 	=> $tipo_de_documento,
                        'DocNro' 	=> $numero_de_documento,
                        'CbteDesde' => $numero_de_factura,
                        'CbteHasta' => $numero_de_factura,
                        'CbteFch' 	=> intval(str_replace('-', '', $fecha)),
                        'FchServDesde'  => $fecha_servicio_desde,
                        'FchServHasta'  => $fecha_servicio_hasta,
                        'FchVtoPago'    => $fecha_vencimiento_pago,
                        'ImpTotal' 	=> $importe_total,
                        'ImpTotConc'=> 0, // Importe neto no gravado
                        'ImpNeto' 	=> $importe_total, // Importe neto
                        'ImpOpEx' 	=> 0, // Importe exento al IVA
                        'ImpIVA' 	=> 0, // Importe de IVA
                        'ImpTrib' 	=> 0, //Importe total de tributos
                        'MonId' 	=> 'PES', //Tipo de moneda usada en la factura ('PES' = pesos argentinos)
                        'MonCotiz' 	=> 1, // Cotización de la moneda usada (1 para pesos argentinos)
                    );

                    /**
                     * Creamos la Factura
                     **/
                    $res = $afip->ElectronicBilling->CreateVoucher($data);
                    $factura = new Factura();
                    $factura->setCodigo($fila['A']);
                    $factura->setDigitalNum($afip->ElectronicBilling->GetLastVoucher($punto_de_venta, $tipo_de_comprobante));
                    $factura->setDigitalPv($punto_de_venta);
                    $factura->setDigitalMonto($fila['E']);
                    $factura->setMontoReal($fila['E']);
                    $factura->setCae($res['CAE']);
                    $factura->setCaeVto($res["CAEFchVto"]);
                    $factura->setFechaEmision(date_create('now'));
                    $factura->setPeriodo(date_create('now'));
                    $factura->setUsuarioFacturacion('SISTEMA');
                    $factura->setHoraFactura(date_create('now'));
                    $factura->setMontoFact($fila['E']);
                    $factura->setHospitalId($hospital);
                    $factura->setCodOs($rnos);
                    $factura->setPuntoVenta($hospital->getPtoVta());
                    $factura->setNumeroFactura($entityManager->getRepository(Factura::class)->findById($hospital->getPtoVta())[0]['numeroFactura'] + 1);
                    $entityManager->persist($factura);
                    $entityManager->flush();
                    /**
                    * Creamos Anexoii
                    */
                    $facturaRepo = $entityManager->getRepository(Factura::class);
                    $servicioRepo = $entityManager->getRepository(Servicios::class);

                    $anexoii = new \App\Entity\Anexoii();
                    $anexoii->setTipoDoc('DNI');
                    $anexoii->setDocumento(99999999);
                    $anexoii->setApeynom('XXXX XXXXX');
                    $anexoii->setFechaNac(date_create('now'));
                    $anexoii->setSexo('M');
                    $anexoii->setCodH($hospital->getCodigoh());
                    $anexoii->setCodOs($factura->getCodOs());
                    $anexoii->setNumAfil('99999999');
                    $anexoii->setTipoBenef('Titular');
                    $anexoii->setParentesco('Otro');
                    $anexoii->setMedicos('M0468');
                    $anexoii->setMesFacturacion(date_create('now'));
                    $anexoii->setCodDev('0');
                    $anexoii->setEstadoAnexo('1');
                    $anexoii->setFechaCarga(date_create('now'));
                    $anexoii->setHoraCarga(date_create('now'));
                    $anexoii->setMes($factura->getFechaEmision()->format('m'));
                    $anexoii->setIdEntrada('34428');
                    $anexoii->setSfGuardUserId(null);
                    $entityManager->persist($anexoii);
                    $entityManager->flush();
                    /**
                     * Creamos ItmePrefacturacion
                     */
                    $itemPrefac = new \App\Entity\ItemPrefacturacion();
                    $itemPrefac->setNumAnexo($anexoii);
                    $itemPrefac->setCodservFK($servicioRepo->findOneByCodserv(269));
                    $itemPrefac->setIdNomencladorFK(2511);
                    $itemPrefac->setCantidad(1);
                    $itemPrefac->setPrecio((string)$factura->getMontoReal());
                    $itemPrefac->setIdFacturaFK($factura);
                    $itemPrefac->setEstadoFactura(0);
                    $itemPrefac->setEstadoPago(0);
                    $itemPrefac->setEstadoItem(0);
                    $itemPrefac->setMontoPago(0);
                    $itemPrefac->setCuotaId(0);
                    $itemPrefac->setCodservFKM('');
                    $itemPrefac->setEstadoDebito(0);
                    $entityManager->persist($itemPrefac);
                    $entityManager->flush();

                else:
                    $error .= 'No se encontro Rnos: '.$fila['G'].'<br>';
                endif;
            endif;

        endforeach;
        if($error):
            $this->addFlash('sonata_flash_error', $error);
        endif;
        return $this->redirectToRoute('admin_app_factura_list');

    }
}
