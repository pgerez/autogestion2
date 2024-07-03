<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\DatePickerType;

final class ReciboAdmin extends AbstractAdmin
{

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('pdf');
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('ptoVta')
            ->add('numero')
            ->add('cheque')
            ->add('monto')
            ->add('fechaEmicion')
            ->add('fechaCobro')
            ->add('observacion')
            ->add('montoForesu')
            ->add('montoIosep')
            ->add('chequeAnses')
            ->add('montoAnses')
            ->add('expediente')
            ->add('ordenPago')
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('ptoVta')
            ->add('numero')
            ->add('cheque')
            ->add('monto')
            ->add('fechaEmicion')
            ->add('fechaCobro')
            ->add('observacion')
            ->add('montoForesu')
            ->add('montoIosep')
            ->add('chequeAnses')
            ->add('montoAnses')
            ->add('expediente')
            ->add('ordenPago')
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'pdf' => ['template' => 'ReciboAdmin/pdf_action.html.twig'],
                    #'show' => [],
                    'edit' => [],
                    #'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            #->add('id')
            ->add('ptoVta', null, ['disabled' => true])
            ->add('numero', null, ['disabled' => true])
            ->add('cheque')
            ->add('monto', null, ['disabled' => true])
            ->add('fechaEmicion',DatePickerType::class, ['label'=>'Fecha Emision', 'format'=>'d/M/y'])
            ->add('fechaCobro',DatePickerType::class, ['label'=>'Fecha Cobro', 'format'=>'d/M/y'])
            #->add('observacion')
            ->add('montoForesu')
            ->add('montoIosep')
            ->add('chequeAnses')
            ->add('montoAnses')
            ->add('expediente')
            ->add('ordenPago')
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('ptoVta')
            ->add('numero')
            ->add('cheque')
            ->add('monto')
            ->add('fechaEmicion')
            ->add('fechaCobro')
            ->add('observacion')
            ->add('montoForesu')
            ->add('montoIosep')
            ->add('chequeAnses')
            ->add('montoAnses')
            ->add('expediente')
            ->add('ordenPago')
            ;
    }
}
