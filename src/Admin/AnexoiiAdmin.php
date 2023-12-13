<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class AnexoiiAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('numAnexo')
            ->add('tipoDoc')
            ->add('documento')
            ->add('apeynom')
            ->add('fechaNac')
            ->add('sexo')
            ->add('codH')
            ->add('codOs')
            ->add('numAfil')
            ->add('tipoBenef')
            ->add('parentesco')
            ->add('medicos')
            ->add('mesFacturacion')
            ->add('codDev')
            ->add('estadoAnexo')
            ->add('fechaCarga')
            ->add('horaCarga')
            ->add('mes')
            ->add('idEntrada')
            ->add('sfGuardUserId')
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('numAnexo')
            ->add('tipoDoc')
            ->add('documento')
            ->add('apeynom')
            ->add('fechaNac')
            ->add('sexo')
            ->add('codH')
            ->add('codOs')
            ->add('numAfil')
            ->add('tipoBenef')
            ->add('parentesco')
            ->add('medicos')
            ->add('mesFacturacion')
            ->add('codDev')
            ->add('estadoAnexo')
            ->add('fechaCarga')
            ->add('horaCarga')
            ->add('mes')
            ->add('idEntrada')
            ->add('sfGuardUserId')
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
            ->add('numAnexo')
            ->add('tipoDoc')
            ->add('documento')
            ->add('apeynom')
            ->add('fechaNac')
            ->add('sexo')
            ->add('codH')
            ->add('codOs')
            ->add('numAfil')
            ->add('tipoBenef')
            ->add('parentesco')
            ->add('medicos')
            ->add('mesFacturacion')
            ->add('codDev')
            ->add('estadoAnexo')
            ->add('fechaCarga')
            ->add('horaCarga')
            ->add('mes')
            ->add('idEntrada')
            ->add('sfGuardUserId')
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('numAnexo')
            ->add('tipoDoc')
            ->add('documento')
            ->add('apeynom')
            ->add('fechaNac')
            ->add('sexo')
            ->add('codH')
            ->add('codOs')
            ->add('numAfil')
            ->add('tipoBenef')
            ->add('parentesco')
            ->add('medicos')
            ->add('mesFacturacion')
            ->add('codDev')
            ->add('estadoAnexo')
            ->add('fechaCarga')
            ->add('horaCarga')
            ->add('mes')
            ->add('idEntrada')
            ->add('sfGuardUserId')
            ;
    }
}
