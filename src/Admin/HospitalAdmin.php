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

final class HospitalAdmin extends AbstractAdmin
{

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        if(!$this->isGranted('ROLE_SUPER_ADMIN')):

            if ($this->isGranted('ROLE_AUTOGESTION')):
                $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
                $query
                    ->where($query->getRootAlias()[0].'.hpgd = 0');
            endif;

            if ($this->isGranted('ROLE_HPGD')):
                $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
                $query
                    ->where($query->getRootAlias()[0].'.id = '.$user->getHospital()->getId());
            endif;

        endif;

        return $query;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('saldos');
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('codigoh', null, ['label' => 'Codigo'])
            ->add('descriph', null, ['label' => 'Nombre'])
            ->add('ptoVta', null, ['label' => 'Punto de Venta'])
            ->add('estado')
            ->add('imputacion')
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('codigoh', null, ['label' => 'Codigo'])
            ->add('descriph', null, ['label' => 'Nombre'])
            ->add('estimulo', null, ['label' => 'Inversion', 'template' => 'HospitalAdmin/estimulo.html.twig'])
            ->add('afectado', null, [ 'template' => 'HospitalAdmin/estimulo.html.twig'])
            ->add('saldo',null, [ 'template' => 'HospitalAdmin/estimulo.html.twig'])
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
            ->add('codigoh', null, ['label' => 'Codigo'])
            ->add('descriph', null, ['label' => 'Nombre'])
            ->add('ptoVta', null, ['label' => 'Punto de Venta'])
            ->add('estado')
            ->add('hpgd')
            #->add('imputacion')
            ->add('email')
            ->add('cuit')
            ->add('condicion')
            ->add('fecha_inicio',DatePickerType::class, Array('label'=>'Inicio de Actividad', 'format'=>'d/M/y'))
            ->add('domicilio')
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
            ->add('condicion')
            ->add('fechaInicio')
            ->add('domicilio')
            ;
    }
}
