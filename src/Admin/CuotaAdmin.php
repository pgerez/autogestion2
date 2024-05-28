<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Factura;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\DatePickerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use App\Form\Type\FormFieldItemType;

final class CuotaAdmin extends AbstractAdmin
{


    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('fechaPago')
            ->add('fechaLiquidacion')
            ->add('numeroComprobante')
            ->add('detalle')
            ->add('monto')
            ->add('numeroCuota')
            ->add('observacion')
            ->add('numeroPago')
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('fechaPago')
            ->add('fechaLiquidacion')
            ->add('numeroComprobante')
            ->add('detalle')
            ->add('monto')
            ->add('numeroCuota')
            ->add('observacion')
            ->add('numeroPago')
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
        $facturas = [];
        if($this->getSubject()->getId()):
            $facturas = $this->getSubject()->getPago()->getFacturas();
        endif;

        $form
            #->add('id')
                ->add('fechaPago', DatePickerType::class, Array('label'=>'Pago', 'format'=>'d/M/y'))
                ->add('fechaLiquidacion', DatePickerType::class, Array('label'=>'Liquidacion', 'format'=>'d/M/y'))
                ->add('tipopago')
                ->add('numeroComprobante')
                ->add('facturas', FormFieldItemType::class, ['mapped' => false, 'facturas' => $facturas])
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('fechaPago')
            ->add('fechaLiquidacion')
            ->add('numeroComprobante')
            ->add('detalle')
            ->add('monto')
            ->add('numeroCuota')
            ->add('observacion')
            ->add('numeroPago')
            ;
    }
}