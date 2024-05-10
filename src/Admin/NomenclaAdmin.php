<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class NomenclaAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('codigon')
            ->add('subcodn')
            ->add('letra')
            ->add('item')
            ->add('arancel')
            ->add('estado')
            ->add('tema')
            ->add('fechaInicio')
            ->add('fechaFin')
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('codigon')
            ->add('subcodn')
            ->add('letra')
            ->add('item')
            ->add('arancel')
            ->add('tema')
            ->add('estado')
            ->add('canPrac')
            ->add('fechaInicio')
            ->add('fechaFin')
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
            #->add('rowId')
            ->add('codigon')
            ->add('subcodn')
            ->add('letra')
            ->add('item')
            ->add('arancel')
            ->add('tema')
            ->add('estado')
            ->add('canPrac')
            ->add('fechaInicio')
            ->add('fechaFin')
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('codigon')
            ->add('subcodn')
            ->add('letra')
            ->add('item')
            ->add('arancel')
            ->add('tema')
            ->add('estado')
            ->add('canPrac')
            ->add('fechaInicio')
            ->add('fechaFin')
            ;
    }
}
