<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use App\Entity\Servicios;
use App\Entity\Factura;

final class ItemPrefacturacionAdmin extends AbstractAdmin
{


    protected $parentAssociationMapping = 'id_factura_FK';
    
    /*
    
    public function  configure(){
        $this->parentAssociationMapping = 'id_factura_FK';
    }

    */
    



    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('numAnexo')
            ->add('codservFk')
            ->add('idNomencladorFk')
            ->add('cantidad')
            ->add('precio')
            ->add('reparto')
            #->add('idFacturaFk')
            ->add('estadoFactura')
            ->add('estadoPago')
            ->add('estadoItem')
            ->add('montoPago')
            ->add('cuotaId')
            ->add('codservFkm')
            ->add('estadoDebito')
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            #->add('Num_Anexo')
            ->add('codservFk.descripcionServicio',null,['label' => 'Servicio'])
            #->add('idNomencladorFk')
            ->add('cantidad')
            ->add('precio')
            #->add('reparto')
            ->add('id_Factura_Fk.numeroCompleto', null, ['label' => 'Factura'])
            #->add('estadoFactura')
            ->add('estadoPago', null, ['label' => 'Pagado?'])
            #->add('estadoItem')
            #->add('montoPago')
            #->add('cuotaId')
            #->add('codservFkm')
            ->add('estadoDebito', null, ['label' => 'Debitado?'])
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $estado = false;
        if($this->getSubject()->getEstadoPago() == 1):
            $estado  = true;
        endif;
        
        $form
            #->add('id')
            ->add('Num_Anexo', ModelListType::class, array(
                    'by_reference' => false,'btn_edit' => false,'btn_delete' => false,'btn_add' => false, 'label' => 'Anexo'
                ))
                ->add('codserv_Fk', EntityType::class, [
                    'class' => Servicios::class,
                    'choice_value' => 'codserv',
                    'choice_label' => function (Servicios $s = null) {
                        return null === $s ? '': $s->getDescripcionServicio();
                    },'label' => 'Servicio',
                    'disabled' => $estado

                ])
            #, ModelListType::class, array(
            #    'by_reference' => false,'btn_edit' => false,'btn_delete' => false,'btn_add' => false, 'label' => 'Servicio'
            #))
            ->add('idNomencladorFk', HiddenType::class)
            ->add('cantidad', HiddenType::class)
            ->add('precio', null, ['disabled' => true])
            #->add('reparto')
            #->add('idFacturaFk')
            #->add('estadoFactura')
            ->add('estadoPago', HiddenType::class)
            #->add('estadoItem')
            #->add('montoPago')
            ->add('cuotaId', HiddenType::class)
            #->add('codservFkm')
            ->add('estadoDebito', HiddenType::class)
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('numAnexo')
            ->add('codservFk', null, ['label' => 'Servicio'])
            ->add('idNomencladorFk', null, ['label' => 'Nomenclador'])
            ->add('cantidad')
            ->add('precio')
            ->add('reparto')
            ->add('idFacturaFk', null, ['label' => 'Factura'])
            ->add('estadoFactura')
            ->add('estadoPago')
            ->add('estadoItem')
            ->add('montoPago')
            ->add('cuotaId')
            ->add('codservFkm')
            ->add('estadoDebito')
            ;
    }


    public function id_factura_FK()
    {
            $admin = $this->isChild() ? $this->getParent()->getSubject() : $this;
            return $admin;
    }   



}
