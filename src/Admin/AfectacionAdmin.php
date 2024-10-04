<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\DatePickerType;

final class AfectacionAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('importe')
            ->add('numero_expediente')
            ->add('fecha')
            ->add('tipo')
            ->add('observacion')
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {

        $list
            ->add('id')
            ->add('numero_expediente')
            ->add('fecha')
            ->add('tipo')
            ->add('observacion')
            ->add('proveedor')
            ->add('importe')
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
        $form
            #->add('id')
            ->add('hospital')
            ->add('proveedor',  ModelListType::class )
            ->add('importe')
            ->add('numero_expediente')
            ->add('fecha', DatePickerType::class, ['format'=>'d/M/y', 'required' => false])
            ->add('tipo')
            ->add('observacion')
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('importe')
            ->add('numero_expediente')
            ->add('fecha')
            ->add('tipo')
            ->add('observacion')
            ;
    }
}
