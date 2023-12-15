<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class ObrasSocialesAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('rowId')
            ->add('codobra')
            ->add('sigla')
            ->add('denomina')
            ->add('domicilio')
            ->add('codPostal')
            ->add('localidad')
            ->add('telefono')
            ->add('codbco')
            ->add('codsuc')
            ->add('ctabanc')
            ->add('estado')
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('rowId')
            ->add('codobra')
            ->add('sigla')
            ->add('denomina')
            ->add('domicilio')
            ->add('codPostal')
            ->add('localidad')
            ->add('telefono')
            ->add('cuit')
            ->add('codsuc')
            ->add('ctabanc')
            ->add('estado')
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
            ->add('rowId')
            ->add('codobra')
            ->add('sigla')
            ->add('denomina')
            ->add('domicilio')
            ->add('codPostal')
            ->add('localidad')
            ->add('telefono')
            ->add('codbco')
            ->add('codsuc')
            ->add('cuit')
            ->add('estado')
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('rowId')
            ->add('codobra')
            ->add('sigla')
            ->add('denomina')
            ->add('domicilio')
            ->add('codPostal')
            ->add('localidad')
            ->add('telefono')
            ->add('codbco')
            ->add('codsuc')
            ->add('ctabanc')
            ->add('cuit')
            ->add('estado')
            ;
    }
}
