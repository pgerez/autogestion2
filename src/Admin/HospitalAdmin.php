<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class HospitalAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('codigoh')
            ->add('descriph')
            ->add('ptoVta')
            ->add('estado')
            ->add('imputacion')
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('codigoh')
            ->add('descriph')
            ->add('estimulo')
            ->add('afectado')
            ->add('saldo')
            #->add('ptoVta')
            #->add('estado')
            #->add('imputacion')
            #->add('hpgd')
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
            ->add('codigoh')
            ->add('descriph')
            ->add('ptoVta')
            ->add('estado')
            ->add('hpgd')
            ->add('imputacion')
            ->add('email')
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('codigoh')
            ->add('descriph')
            ->add('ptoVta')
            ->add('estado')
            ->add('imputacion')
            ;
    }
}
