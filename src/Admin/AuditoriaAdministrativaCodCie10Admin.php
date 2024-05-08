<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class AuditoriaAdministrativaCodCie10Admin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('codCie10Id')
            ->add('auditoriaAdministrativaNumAnexo')
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('codCie10Id')
            ->add('auditoriaAdministrativaNumAnexo')
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
            ->add('codCie10Id', null, ['label' => 'Cie10'])
            #->add('auditoriaAdministrativaNumAnexo')
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('codCie10Id')
            ->add('auditoriaAdministrativaNumAnexo')
            ;
    }
}
