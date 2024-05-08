<?php

declare(strict_types=1);

namespace App\Admin;


use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Sonata\Form\Type\DatePickerType;
use Sonata\Form\Type\DateTimePickerType;
use App\Entity\ObrasSociales;
use App\Entity\Hospital;
use App\Entity\Factura;
use App\Entity\Servicios;
use Afip;

final class FacturaAdmin extends AbstractAdmin
{
    protected $datagridValues = array(
        '_sort_order' => 'DESC',
        #'_sort_by' => 'foo',
    );

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        if (!$this->isGranted('ROLE_AUTOGESTION') and !$this->isGranted('ROLE_SUPER_ADMIN')):
            $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
            $query
                #->join($query->getRootAlias()[0].'.hospitalId', 'h', 'WITH', $query->getRootAlias()[0].'.hospitalId = h.id')
                ->where($query->getRootAlias()[0].'.hospitalId = '.$user->getHospital()->getId() )
                ->andWhere($query->getRootAlias()[0].'.sistema = 1');
        endif;
        
        return $query;
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            #->add('idFactura')
            ->add('puntoVenta')
            ->add('numeroFactura')
            ->add('fechaEmision')
            #->add('periodo')
            #->add('usuarioFacturacion')
            #->add('horaFactura')
            ->add('codOs')
            ->add('montoFact')
            #->add('montoReal')
            #->add('codEstadofacturaFk')
            #->add('tipoFact')
            #->add('estadoId')
            #->add('fechaEnvio')
            #->add('fechaAcuse')
            #->add('pagoId')
            #->add('debito')
            #->add('tipoDebitoId')
            ->add('hospitalId')
            #->add('cartaDocumento')
            #->add('fechaCarta')
            #->add('digitalPv')
            #->add('digitalNum')
            #->add('digitalFecha')
            #->add('digitalMonto')
            #->add('fechaEnvioSuper')
            #->add('fechaFiscEstado')
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('idFactura')
            #->add('codigo')
            ->add('puntoVenta',null,['label' => 'PV OP'])
            ->add('numeroFactura',null,['label' => 'Num OP'])
            #->add('digitalPv',null,['label' => 'PV Digital'])
            #->add('digitalNum',null,['label' => 'Num Digital'])
            ->add('numeroCompleto', null, ['label' => 'Factura Digital'])
            ->add('fechaEmision')
            #->add('periodo')
            #->add('usuarioFacturacion')
            #->add('horaFactura')
            ->add('codOs',null,['label' => 'OS'])
            ->add('montoFact',null,['label' => 'Monto'])
            #->add('montoReal')
            #->add('codEstadofacturaFk')
            #->add('tipoFact')
            #->add('estadoId')
            #->add('fechaEnvio')
            #->add('fechaAcuse')
            #->add('pagoId')
            #->add('debito')
            #->add('tipoDebitoId')
            ->add('hospitalId',null,['label' => 'Hospital'])
            #->add('itemPrefacturacions',null,['label' => 'Servicio'])
            #->add('cartaDocumento')
            #->add('fechaCarta')

            #->add('digitalFecha')
            #->add('digitalMonto')
            #->add('fechaEnvioSuper')
            #->add('cae')
            #->add('cae_vto')
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'items' => ['template' => 'ItemPrefacturacionAdmin/items.html.twig'],
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $disabled = true;
        #if (!$this->isGranted('ROLE_AUTOGESTION') and !$this->isGranted('ROLE_SUPER_ADMIN')):
        #    $hidden = true
        #endif;
        if($this->getSubject()->getIdFactura() === null):
            $disabled = false;
        endif;

        $form
            #->add('idFactura')
            #->add('puntoVenta')
            #->add('numeroFactura')
            ->add('fechaEmision', DatePickerType::class, Array('label'=>'Emision', 'format'=>'d/M/y'))
            ->add('periodo', DatePickerType::class, Array('label'=>'Periodo', 'format'=>'d/M/y'))
            ->add('usuarioFacturacion')#, ['hidden' => true])
            ->add('horaFactura', DateTimePickerType::class, [ 'format' => 'H:m'])
            ->add('codOs', EntityType::class, [
                'class' => ObrasSociales::class,
                #'choice_label' => 'codobra',
                'choice_value' => 'codobra',
                'choice_label' => function (ObrasSociales $os = null) {
                    return null === $os ? '': $os->getCodobra().'-'.$os->getDenomina();
                },
  

            ])
            ->add('montoFact', null, ['required' => true])
            #->add('montoReal', null, ['required' => true])
            #->add('codEstadofacturaFk')
            #->add('tipoFact')
            #->add('estadoId')
            #->add('fechaEnvio')
            #->add('fechaAcuse')
            #->add('pagoId')
            #->add('debito')
            #->add('tipoDebitoId')
            ->add('hospitalId', null, ['disabled' => $disabled])
            #->add('cartaDocumento')
            #->add('fechaCarta')
            ->add('digitalPv', null, ['required' => true])
            ->add('digitalNum', null, ['required' => true])
            ->add('cae')
            #->add('digitalFecha', DatePickerType::class, Array('label'=>'Emision Digital', 'format'=>'d/M/y'))
            #->add('digitalMonto')
            #->add('fechaEnvioSuper')
            #->add('fechaFiscEstado')
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('idFactura')
            ->add('puntoVenta')
            ->add('numeroFactura')
            ->add('fechaEmision')
            ->add('periodo')
            ->add('usuarioFacturacion')
            ->add('horaFactura')
            ->add('codOs')
            ->add('montoFact')
            ->add('montoReal')
            ->add('codEstadofacturaFk')
            ->add('tipoFact')
            ->add('estadoId')
            ->add('fechaEnvio')
            ->add('fechaAcuse')
            ->add('pagoId')
            ->add('debito')
            ->add('tipoDebitoId')
            ->add('hospitalId')
            ->add('cartaDocumento')
            ->add('fechaCarta')
            ->add('digitalPv')
            ->add('digitalNum')
            ->add('digitalFecha')
            ->add('digitalMonto')
            ->add('fechaEnvioSuper')
            ->add('fechaFiscEstado')
            ;
    }

    public function prePersist($object)
     {

//        $afip = new Afip(array('CUIT' => 20265863206)); //Reemplazar el CUIT
//        /**
//         * Numero del punto de venta
//         **/
//        $punto_de_venta = 3;
//
//        /**
//         * Tipo de factura
//         **/
//        $tipo_de_comprobante = 11; // 11 = Factura C
//
//        /**
//         * Número de la ultima Factura C
//         **/
//        $last_voucher = $afip->ElectronicBilling->GetLastVoucher($punto_de_venta, $tipo_de_comprobante);
//
//        /**
//         * Concepto de la factura
//         *
//         * Opciones:
//         *
//         * 1 = Productos
//         * 2 = Servicios
//         * 3 = Productos y Servicios
//         **/
//        $concepto = 2;
//
//        /**
//         * Tipo de documento del comprador
//         *
//         * Opciones:
//         *
//         * 80 = CUIT
//         * 86 = CUIL
//         * 96 = DNI
//         * 99 = Consumidor Final
//         **/
//        $tipo_de_documento = 99;
//
//        /**
//         * Numero de documento del comprador (0 para consumidor final)
//         **/
//        $numero_de_documento = 0;
//
//        /**
//         * Numero de comprobante
//         **/
//        $numero_de_factura = $last_voucher+1;
//
//        /**
//         * Fecha de la factura en formato aaaa-mm-dd (hasta 10 dias antes y 10 dias despues)
//         **/
//        $fecha = date('Y-m-d');
//
//        /**
//         * Importe de la Factura
//         **/
//        $importe_total = 100;
//
//        /**
//         * Los siguientes campos solo son obligatorios para los conceptos 2 y 3
//         **/
//        if ($concepto === 2 || $concepto === 3) {
//            /**
//             * Fecha de inicio de servicio en formato aaaammdd
//             **/
//            $fecha_servicio_desde = intval(date('Ymd'));
//
//            /**
//             * Fecha de fin de servicio en formato aaaammdd
//             **/
//            $fecha_servicio_hasta = intval(date('Ymd'));
//
//            /**
//             * Fecha de vencimiento del pago en formato aaaammdd
//             **/
//            $fecha_vencimiento_pago = intval(date('Ymd'));
//        }
//        else {
//            $fecha_servicio_desde = null;
//            $fecha_servicio_hasta = null;
//            $fecha_vencimiento_pago = null;
//        }
//
//
//        $data = array(
//            'CantReg' 	=> 1, // Cantidad de facturas a registrar
//            'PtoVta' 	=> $punto_de_venta,
//            'CbteTipo' 	=> $tipo_de_comprobante,
//            'Concepto' 	=> $concepto,
//            'DocTipo' 	=> $tipo_de_documento,
//            'DocNro' 	=> $numero_de_documento,
//            'CbteDesde' => $numero_de_factura,
//            'CbteHasta' => $numero_de_factura,
//            'CbteFch' 	=> intval(str_replace('-', '', $fecha)),
//            'FchServDesde'  => $fecha_servicio_desde,
//            'FchServHasta'  => $fecha_servicio_hasta,
//            'FchVtoPago'    => $fecha_vencimiento_pago,
//            'ImpTotal' 	=> $importe_total,
//            'ImpTotConc'=> 0, // Importe neto no gravado
//            'ImpNeto' 	=> $importe_total, // Importe neto
//            'ImpOpEx' 	=> 0, // Importe exento al IVA
//            'ImpIVA' 	=> 0, // Importe de IVA
//            'ImpTrib' 	=> 0, //Importe total de tributos
//            'MonId' 	=> 'PES', //Tipo de moneda usada en la factura ('PES' = pesos argentinos)
//            'MonCotiz' 	=> 1, // Cotización de la moneda usada (1 para pesos argentinos)
//        );


        /** 
         * Creamos la Factura 
         **/
        #$res = $afip->ElectronicBilling->CreateVoucher($data);

        #$object->setDigitalNum($afip->ElectronicBilling->GetLastVoucher($punto_de_venta, $tipo_de_comprobante));
        #$object->setDigitalPv($punto_de_venta);

        $object->setDigitalMonto($object->getMontoFact());
        $object->setMontoReal($object->getMontoFact());
        $object->setCae('CAE-MODIFICAR');
        #$object->setCae($res['CAE']);
     }

    public function postPersist($object)
     {
         #$equipotrabajoManager = $this->getModelManager()
         #        ->getEntityManager('App\Entity\EquipoTrabajo');
         $anexoiiManager = $this->getModelManager()
                 ->getEntityManager('App\Entity\Anexoii');
         $itemPrefacturacionManager = $this->getModelManager()
                 ->getEntityManager('App\Entity\ItemPrefacturacion');
         $facturaRepo = $this->getModelManager()->getEntityManager(Factura::class)->getRepository(Factura::class);
         $servicioRepo = $this->getModelManager()->getEntityManager(Servicios::class)->getRepository(Servicios::class);
         
         $object->setPuntoVenta($object->getHospitalId()->getPtoVta());
         $object->setNumeroFactura($facturaRepo->findById($object->getHospitalId()->getPtoVta())[0]['numeroFactura'] + 1);

         $anexoii = new \App\Entity\Anexoii();
         $anexoii->setTipoDoc('DNI');
         $anexoii->setDocumento(99999999);
         $anexoii->setApeynom('XXXX XXXXX');
         $anexoii->setFechaNac($object->getFechaEmision());
         $anexoii->setSexo('M');    
         $anexoii->setCodH($object->getHospitalId()->getCodigoh());
         $anexoii->setCodOs($object->getCodOs());
         $anexoii->setNumAfil('99999999');
         $anexoii->setTipoBenef('Titular');
         $anexoii->setParentesco('Otro');
         $anexoii->setMedicos('M0468');
         $anexoii->setMesFacturacion($object->getFechaEmision());
         $anexoii->setCodDev('0');
         $anexoii->setEstadoAnexo('1');
         $anexoii->setFechaCarga(date_create('now'));
         $anexoii->setHoraCarga(date_create('now'));
         $anexoii->setMes($object->getFechaEmision()->format('m'));
         $anexoii->setIdEntrada('34428');
         $anexoii->setSfGuardUserId(null);
         $anexoiiManager->persist($anexoii);
         $anexoiiManager->flush();

         #echo $object->getIdFactura();exit;
         $itemPrefac = new \App\Entity\ItemPrefacturacion();
         $itemPrefac->setNumAnexo($anexoii);
         $itemPrefac->setCodservFK($servicioRepo->findOneByCodserv(269));
         $itemPrefac->setIdNomencladorFK(2511);
         $itemPrefac->setCantidad(1);
         $itemPrefac->setPrecio((string)$object->getMontoReal());
         $itemPrefac->setIdFacturaFK($object);
         $itemPrefac->setEstadoFactura(0);
         $itemPrefac->setEstadoPago(0);
         $itemPrefac->setEstadoItem(0);
         $itemPrefac->setMontoPago(0);
         $itemPrefac->setCuotaId(0);
         $itemPrefac->setCodservFKM('');
         $itemPrefac->setEstadoDebito(0);
         $itemPrefacturacionManager->persist($itemPrefac);
         $itemPrefacturacionManager->flush();
         
         
            
     } 
}
