<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Hospital;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\DatePickerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

final class EstimuloAdmin extends AbstractAdmin
{

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $arrayHpgd = $this->getModelManager()->getEntityManager(Hospital::class)->getRepository(Hospital::class)->arrayHpgd();
        if (!$this->isGranted('ROLE_AUTOGESTION') and !$this->isGranted('ROLE_SUPER_ADMIN')):
            $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
            $query
                #->join($query->getRootAlias()[0].'.hospitalId', 'h', 'WITH', $query->getRootAlias()[0].'.hospitalId = h.id')
                ->where($query->getRootAlias()[0].'.hospitalId = '.$user->getHospital()->getId() )
                ->andWhere($query->getRootAlias()[0].'.sistema = 1');
        endif;

        if ($this->isGranted('ROLE_AUTOGESTION') or $this->isGranted('ROLE_SUPER_ADMIN')):
            $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
            $query
                #->join($query->getRootAlias()[0].'.hospitalId', 'h', 'WITH', $query->getRootAlias()[0].'.hospitalId = h.id')
                ->where($query->getRootAlias()[0].'.hospitalId NOT IN (:array)')
                #->andWhere($query->getRootAlias()[0].'.sistema = 1')
                ->setParameter('array',$arrayHpgd);
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
            #->add('liquidacion')
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            #->add('numero')
            #->add('detalle')
            #->add('estado')
            ->add('liquidacion')
            ->add('hospitalId')
            ->add('pagado', null, ['editable' => true])
            ->add('monto',null, ['template' => 'EstimuloAdmin/currency.html.twig'])
            ->add('recibo')
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => ['template' => 'EstimuloAdmin/cuotas.html.twig'],
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
