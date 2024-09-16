<?php

namespace App\Controller;

use App\Entity\Estado;
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

        $em = $this->getDoctrine()->getManager();
        $items = $em->getRepository(ItemPrefacturacion::class)->findItemsByHospAndOS($hospitalid,$osid,$fechai,$fechaf);

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
        $check = $request->get('idx');
        $em = $this->getDoctrine()->getManager();
        $os = $em->getRepository(ObrasSociales::class)->find($osid);
        if(isset($check)):
            $error = 0;
            ##calculo total a facturar#####
            $montoFact = $em->getRepository(ItemPrefacturacion::class)->findTotalItems($check);
            $afip = new Afip(array('CUIT' => $_ENV['CUIT'], 'production' => TRUE)); //Reemplazar el CUIT
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
            $tipo_de_documento = 80;

            /**
             * Numero de documento del comprador (0 para consumidor final) CUIT OS
             **/
            $numero_de_documento = $os->getCuit();

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
            $hospital = $em->getRepository(Hospital::class)->find($hospitalid);
            $estado = $em->getRepository(Estado::class)->find(1);
            $object = new Factura();
            $res = $afip->ElectronicBilling->CreateVoucher($data);
            $object->setDigitalNum($afip->ElectronicBilling->GetLastVoucher($punto_de_venta, $tipo_de_comprobante));
            $object->setDigitalPv($punto_de_venta);
            $object->setEstadoId($estado);
            $object->setTipoFact('C');
            $object->setDigitalMonto($montoFact);
            $object->setCodOs($os);
            $object->setHospitalId($hospital);
            $object->setMontoReal($montoFact);
            $object->setMontoFact($montoFact);
            $object->setPuntoVenta($hospital->getPtoVta());
            $object->setNumeroFactura($em->getRepository(Factura::class)->findById($hospital->getPtoVta())[0]['numeroFactura'] + 1);
            #$object->setCae('CAE-MODIFICAR');
            $object->setCae($res['CAE']);
            $object->setCaeVto($res['CAEFchVto']);
            $em->persist($object);
            $em->flush();
            ###update id factura en items#####
            $result = $em->getRepository(ItemPrefacturacion::class)->updateIdfacturaItems($check, $object->getIdFactura());
            $hospitals = $em->getRepository('App\Entity\Hospital')->findAll();
            $oss = $em->getRepository('App\Entity\ObrasSociales')->findAll();

            return $this->render('facturacion/index.html.twig', [
                'controller_name' => 'FacturacionController',
                'hospitals' => $hospitals,
                'oss' => $oss,
                'success' => 1
            ]);

        else:
            $error = 1;
            $items = $em->getRepository(ItemPrefacturacion::class)->findItemsByHospAndOS($hospitalid,$osid,$fechai,$fechaf);

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

    /**
     * @Route("/processNotaDeCredito", name="process_nota_de_credito")
     * @return Response
     */
    public function generarNotaDeCredito(Request $request): Response
    {
        $fid = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $factura = $em->getRepository(Factura::class)->find($fid);

        $afip = new Afip(array('CUIT' => $_ENV['CUIT'], 'production' => TRUE)); //Reemplazar el CUIT
        /**
         * Numero del punto de venta
         **/
        $punto_de_venta = $_ENV['PTO_VTA'];

        /**
         * Tipo de Nota de Crédito
         **/
        $tipo_de_nota = 13; // 13 = Nota de Crédito C

        /**
         * Número de la ultima Nota de Crédito C
         **/
        $last_voucher = $afip->ElectronicBilling->GetLastVoucher($punto_de_venta, $tipo_de_nota);

        /**
         * Numero del punto de venta de la Factura
         * asociada a la Nota de Crédito
         **/
        $punto_factura_asociada = $_ENV['PTO_VTA'];

        /**
         * Tipo de Factura asociada a la Nota de Crédito
         **/
        $tipo_factura_asociada = 11; // 11 = Factura C

        /**
         * Numero de Factura asociada a la Nota de Crédito
         **/
        $numero_factura_asociada = $factura->getDigitalNum();

        /**
         * Concepto de la Nota de Crédito
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
        $numero_de_documento = $_ENV['CUIT'];#cuit ministerio de salud

        /**
         * Numero de comprobante
         **/
        $numero_de_nota = $last_voucher+1;

        /**
         * Fecha de la Nota de Crédito en formato aaaa-mm-dd (hasta 10 dias antes y 10 dias despues)
         **/
        $fecha = date('Y-m-d');

        /**
         * Importe de la Nota de Crédito
         **/
        $importe_total = $factura->getMontoFact();

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
            'CantReg' 	=> 1, // Cantidad de Notas de Crédito a registrar
            'PtoVta' 	=> $punto_de_venta,
            'CbteTipo' 	=> $tipo_de_nota,
            'Concepto' 	=> $concepto,
            'DocTipo' 	=> $tipo_de_documento,
            'DocNro' 	=> $numero_de_documento,
            'CbteDesde' => $numero_de_nota,
            'CbteHasta' => $numero_de_nota,
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
            'MonId' 	=> 'PES', //Tipo de moneda usada en el comprobante ('PES' = pesos argentinos)
            'MonCotiz' 	=> 1, // Cotización de la moneda usada (1 para pesos argentinos)
            'CbtesAsoc' => array( //Factura asociada
                array(
                    'Tipo' 		=> $tipo_factura_asociada,
                    'PtoVta' 	=> $punto_factura_asociada,
                    'Nro' 		=> $numero_factura_asociada,
                )
            )
        );

        /**
         * Creamos la Nota de Crédito
         **/
        $estadoN = $em->getRepository(Estado::class)->find(14);
        $res = $afip->ElectronicBilling->CreateVoucher($data);
        $object = new Factura();
        $object->setDigitalNum($afip->ElectronicBilling->GetLastVoucher($punto_de_venta, $tipo_de_nota));
        #$object->setDigitalNum(1);
        $object->setDigitalPv($factura->getDigitalPv());
        $object->setEstadoId($estadoN);
        $object->setTipoFact('NC');
        $object->setDigitalMonto($factura->getDigitalMonto());
        $object->setCodOs($factura->getCodOs());
        $object->setHospitalId($factura->getHospitalId());
        $object->setMontoReal($factura->getMontoReal());
        $object->setMontoFact($factura->getMontoFact());
        $object->setPuntoVenta($factura->getPuntoVenta());
        $object->setNumeroFactura($em->getRepository(Factura::class)->findById($factura->getHospitalId()->getPtoVta())[0]['numeroFactura'] + 1);
        #$object->setCae('CAE-notacredito');
        $object->setCaeVto($res['CAEFchVto']);
        #$object->setCaeVto(new \DateTime());
        $object->setCae($res['CAE']);
        $object->setFacturaIdFactura($factura);
        $em->persist($object);
        $estadoF = $em->getRepository(Estado::class)->find(6);
        $factura->setEstadoId($estadoF);
        $em->persist($factura);
        ###vuelvo a estado de prefacturacion a los items
        foreach ($factura->getItemPrefacturacions() as $i){
            $i->setIdFacturaFK(null);
            $em->persist($i);
        }
        $em->flush();
        $this->addFlash('sonata_flash_success', 'Nota de credito generada exitosamente.');
        return $this->redirectToRoute('admin_app_factura_list');

    }
}
