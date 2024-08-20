<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\DatePickerType;

final class EstimuloAdmin extends AbstractAdmin
{

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        if (!$this->isGranted('ROLE_AUTOGESTION') and !$this->isGranted('ROLE_SUPER_ADMIN')):
            $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
            $query
                #->join($query->getRootAlias()[0].'.hospitalId', 'h', 'WITH', $query->getRootAlias()[0].'.hospitalId = h.id')
                ->where($query->getRootAlias()[0].'.hospitalId = '.$user->getHospital()->getId() )
                ->andWhere($query->getRootAlias()[0].'.sistema = 1');
        endif;

        return $query;
    }

    public function getBatchActions()
    {
        $actions = [];

        if ($this->hasRoute('delete') && $this->hasAccess('delete')) {
            $actions['recibo'] = [
                'label' => 'Recibo',
                'ask_confirmation' => true,
                'controller' => 'app.controller.estimulo::batchReciboAction',
                // Or 'App/Controller/MergeController::batchMergeAction' base on how you declare your controller service.
            ];
        }

        $actions = $this->configureBatchActions($actions);

        return $actions;
    }


    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('numero')
            ->add('detalle')
            ->add('estado')
            ->add('hospitalId')
            ->add('fecha')
            ->add('pagado')
            ->add('monto')
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('numero')
            #->add('detalle')
            #->add('estado')
            ->add('hospitalId')
            ->add('fecha')
            ->add('pagado', null, ['editable' => true])
            ->add('monto')
            ->add('recibo')
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
            ->add('numero')
            ->add('detalle')
            ->add('estado')
            ->add('hospitalId')
            ->add('fecha',DatePickerType::class, Array('label'=>'Fecha', 'format'=>'d/M/y'))
            ->add('pagado')
            ->add('monto')
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('numero')
            ->add('detalle')
            ->add('estado')
            ->add('hospitalId')
            ->add('fecha')
            ->add('pagado')
            ->add('monto')
            ;
    }
}
