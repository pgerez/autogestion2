<?php

declare(strict_types=1);

namespace App\Admin;


use App\Entity\Estado;
use App\Entity\Nomencla;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
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

    public function getBatchActions()
    {
        $actions = parent::getBatchActions();
        unset($actions['delete']);

        return $actions;
    }

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

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('listitems');
        $collection->add('saveitems');
        $collection->add('pdf');
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
            ->add('estadoId',null, ['label' => 'Estado'])
            #->add('fechaEnvio')
            #->add('fechaAcuse')
            #->add('pagoId')
            #->add('debito')
            #->add('tipoDebitoId')
            ->add('hospitalId')
            #->add('cartaDocumento')
            #->add('fechaCarta')
            ->add('digitalPv')
            ->add('digitalNum')
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
            ->add('fechaEmision', null, ['label' => 'Emision','format'=>'d-m-y'])
            #->add('periodo')
            #->add('usuarioFacturacion')
            #->add('horaFactura')
            ->add('codOs',null,['label' => 'OS'])
            ->add('montoFact',null,['label' => 'Monto'])
            #->add('montoReal')
            #->add('codEstadofacturaFk')


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
            ->add('cae')
            ->add('cae_vto', null, ['format'=>'d-m-y'])
            ->add('estadoId', null,['label' => 'Estado']);
        if ($this->isGranted('ROLE_AUTOGESTION') or $this->isGranted('ROLE_SUPER_ADMIN')):
            $list->add('tipoFact', null, ['label' => 'Cert Deuda', 'template' => 'factura/progress.html.twig']);
        endif;
        $list
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'PDF' => ['template' => 'FacturaAdmin/pdf.html.twig'],
                    'Anular' => ['template' => 'FacturaAdmin/notacredito.html.twig'],
                    'show' => [],
                    'edit' => [],
                    #'delete' => [],
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
            ->add('codOs', null, ['disabled' => $disabled])
            ->add('montoFact', null, ['required' => true])
            #->add('montoReal', null, ['required' => true])
            #->add('codEstadofacturaFk')
            #->add('tipoFact')
            #->add('estadoId',null, ['label' => 'Estado'])
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
            ->add('cae', null, ['label' => 'CAE'])
            ->add('cae_vto', DatePickerType::class, Array('label'=>'Fecha CAE', 'format'=>'d/M/y'))
            #->add('digitalFecha', DatePickerType::class, Array('label'=>'Emision Digital', 'format'=>'d/M/y'))
            #->add('digitalMonto')
            #->add('fechaEnvioSuper')
            #->add('fechaFiscEstado')
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('itemPrefacturacions', null, array('template' => 'factura/items.html.twig', 'label' => false))
            ;
    }

    public function prePersist($object)
    {
        $estado = $this->getModelManager()->getEntityManager(Estado::class)->getRepository(Estado::class)->find(1);
        $object->setMontoReal($object->getMontoFact());
        $object->setEstadoId($estado);
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
         $osRepo = $this->getModelManager()->getEntityManager(ObrasSociales::class)->getRepository(ObrasSociales::class);
         $nomenclaRepo = $this->getModelManager()->getEntityManager(Nomencla::class)->getRepository(Nomencla::class);
         
         $object->setPuntoVenta($object->getHospitalId()->getPtoVta());
         $object->setNumeroFactura($facturaRepo->findById($object->getHospitalId()->getPtoVta())[0]['numeroFactura'] + 1);

         $anexoii = new \App\Entity\Anexoii();
         $anexoii->setTipoDoc('DNI');
         $anexoii->setDocumento(99999999);
         $anexoii->setApeynom('XXXX XXXXX');
         $anexoii->setFechaNac($object->getFechaEmision());
         $anexoii->setSexo('M');    
         $anexoii->setCodH($object->getHospitalId());
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
         $itemPrefac->setNomencla($nomenclaRepo->findOneById(1));
         $itemPrefac->setCantidad(1);
         $itemPrefac->setPrecio((string)$object->getMontoReal());
         $itemPrefac->setIdFacturaFK($object);
         $itemPrefac->setEstadoFactura(0);
         $itemPrefac->setEstadoPago(0);
         $itemPrefac->setEstadoItem(0);
         $itemPrefac->setMontoPago(0);
         #$itemPrefac->setCuota(0);
         $itemPrefac->setCodservFKM('');
         $itemPrefac->setEstadoDebito(0);
         $itemPrefacturacionManager->persist($itemPrefac);
         $itemPrefacturacionManager->flush();
         
         
            
     } 
}
