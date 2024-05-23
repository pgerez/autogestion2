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

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        if (!$this->isGranted('ROLE_AUTOGESTION') and !$this->isGranted('ROLE_SUPER_ADMIN')):
            $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
            $query
                #->join($query->getRootAlias()[0].'.hospitalId', 'h', 'WITH', $query->getRootAlias()[0].'.hospitalId = h.id')
                ->andWhere($query->getRootAlias()[0].'.estado = 1')
                ->andWhere($query->getRootAlias()[0].".fechaInicio = '2022-10-4'");
        endif;

        return $query;
    }

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
