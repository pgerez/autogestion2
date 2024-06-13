<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\DatePickerType;

final class LiquidacionAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('fechaDesde')
            ->add('fechaHasta')
            ->add('observacion')
            ->add('obrasSocialesRowId')
            ->add('hospitalId')
            ->add('acreditar')
            ->add('expedienteNum')
            ->add('expedienteCod')
            ->add('expedienteAnio')
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('fechaDesde')
            ->add('fechaHasta')
            ->add('observacion')
            ->add('obrasocial')
            ->add('hospital')
            ->add('acreditar')
            ->add('expedienteNum')
            ->add('expedienteCod')
            ->add('expedienteAnio')
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
        $disabled = false;
        if(count($this->getSubject()->getCuotas()) > 0):
                $disabled = true;
        endif;

        $form
            #->add('observacion')
            ->add('obrasocial')
            ->add('hospital')
            ->add('fechaDesde', DatePickerType::class, Array('label'=>'Desde', 'format'=>'d/M/y', 'disabled' => $disabled))
            ->add('fechaHasta', DatePickerType::class, Array('label'=>'Hasta', 'format'=>'d/M/y', 'disabled' => $disabled))
            ->add('acreditar')
            ->add('expedienteNum', null, ['label' => 'Exp Numero'])
            ->add('expedienteCod', null, ['label' => 'Exp Codigo'])
            ->add('expedienteAnio', null, ['label' => 'Exp Año'])
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            #->add('id')
            #->add('fechaDesde')
            #->add('fechaHasta')
            #->add('observacion')
            #->add('obrasocial')
            #->add('hospital')
            #->add('acreditar')
            #->add('expedienteNum')
            #->add('expedienteCod')
            ->add('expedienteAnio', null, array('template' => 'liquidacion/cuotas.html.twig', 'label' => false))
            ;
    }
}
