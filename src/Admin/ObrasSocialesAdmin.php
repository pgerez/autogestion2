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

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        if (!$this->isGranted('ROLE_AUTOGESTION') and !$this->isGranted('ROLE_SUPER_ADMIN')):
            $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
            $query
                #->join($query->getRootAlias()[0].'.hospitalId', 'h', 'WITH', $query->getRootAlias()[0].'.hospitalId = h.id')
                ->where($query->getRootAlias()[0].'.estado = 1');
        endif;

        return $query;
    }
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
            ->add('provincia')
            ->add('telefono')
            ->add('cuit')
            ->add('codsuc')
            ->add('ctabanc')
            ->add('estado')
            ->add('email')
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
            ->add('provincia')
            ->add('telefono')
            ->add('codbco')
            ->add('codsuc')
            ->add('cuit')
            ->add('email')
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
