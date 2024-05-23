<?php

namespace App\Controller;

use App\Entity\ItemPrefacturacion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Factura;
use App\Entity\ObrasSociales;
use App\Entity\Hospital;
use App\Entity\Servicios;
use Afip;

class FacturacionController extends AbstractController
{
    /**
     * @Route("/facturacion", name="app_facturacion")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $hospitals = $em->getRepository('App\Entity\Hospital')->findAll();
        $oss = $em->getRepository('App\Entity\ObrasSociales')->findAll();

        return $this->render('facturacion/index.html.twig', [
            'controller_name' => 'FacturacionController',
            'hospitals' => $hospitals,
            'oss' => $oss,
            'success' => 0
        ]);
    }

    /**
     * @Route("/processfacturacion", name="process_facturacion")
     * @return Response
     */
    public function facturar(Request $request): Response
    {
        $hospitalid = $request->get('hospitalid');
        $osid = $request->get('obrasocialid');
        $fechai = $request->get('fechainicio');
        $fechaf = $request->get('fechafin');

        $entityManager = $this->getDoctrine()->getManager();
        $items = $entityManager->getRepository(ItemPrefacturacion::class)->findItemsByHospAndOS($hospitalid,$osid,$fechai,$fechaf);

        return $this->render('facturacion/list.html.twig', [
            'controller_name' => 'FacturacionController',
            'items' => $items,
            'hospitalid' => $hospitalid,
            'os' => $osid,
            'fechai' => $fechai,
            'fechaf' => $fechaf,
            'error' => 0
        ]);

    }

    /**
     * @Route("/processitemsfacturacion", name="process_items_facturacion")
     * @return Response
     */
    public function generarFactura(Request $request): Response
    {
        $hospitalid = $request->get('hospitalid');
        $osid = $request->get('obrasocialid');
        $fechai = $request->get('fechainicio');
        $fechaf = $request->get('fechafin');
        $check = $request->get('checkbox');

        if(isset($check)):
            $error = 0;
            ##calculo total a facturar#####
            $entityManager = $this->getDoctrine()->getManager();
            $montoFact = $entityManager->getRepository(ItemPrefacturacion::class)->findTotalItems($check);

            $afip = new Afip(array('CUIT' => $_ENV['CUIT'], 'production' => $_ENV['PRODUCCION'])); //Reemplazar el CUIT
            echo $afip;exit;
            /**
             * Numero del punto de venta
             **/
            $punto_de_venta = $_ENV['PTO_VTA'];

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
            $tipo_de_documento = 99;

            /**
             * Numero de documento del comprador (0 para consumidor final)
             **/
            $numero_de_documento = 0;

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
            $importe_total = $montoFact;

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
            $facturaManager = $this->getModelManager()
                            ->getEntityManager(Factura::class);
            $object = new Factura();
            $res = $afip->ElectronicBilling->CreateVoucher($data);
            $object->setDigitalNum($afip->ElectronicBilling->GetLastVoucher($punto_de_venta, $tipo_de_comprobante));
            $object->setDigitalPv($punto_de_venta);
            $object->setTipoFact('C');
            $object->setDigitalMonto($montoFact);
            $object->setMontoReal($montoFact);
            #$object->setCae('CAE-MODIFICAR');
            $object->setCae($res['CAE']);
            $facturaManager->persist($object);
            $facturaManager->flush();
            ###update id factura en items#####
            $result = $entityManager->getRepository(ItemPrefacturacion::class)->updateIdfacturaItems($check, $object->getIdFactura());
            $hospitals = $entityManager->getRepository('App\Entity\Hospital')->findAll();
            $oss = $entityManager->getRepository('App\Entity\ObrasSociales')->findAll();

            return $this->render('facturacion/index.html.twig', [
                'controller_name' => 'FacturacionController',
                'hospitals' => $hospitals,
                'oss' => $oss,
                'success' => 1
            ]);

        else:
            $error = 1;
            $entityManager = $this->getDoctrine()->getManager();
            $items = $entityManager->getRepository(ItemPrefacturacion::class)->findItemsByHospAndOS($hospitalid,$osid,$fechai,$fechaf);

            return $this->render('facturacion/list.html.twig', [
                'controller_name' => 'FacturacionController',
                'items' => $items,
                'hospitalid' => $hospitalid,
                'os' => $osid,
                'fechai' => $fechai,
                'fechaf' => $fechaf,
                'error' => $error
            ]);
        endif;

    }
}
