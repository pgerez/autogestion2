<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Hospital;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\DatePickerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

final class IncrementoAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('importe')
            ->add('numero_expediente')
            ->add('fecha')
            ->add('tipo')
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('hospital')
            ->add('importe')
            ->add('numero_expediente')
            ->add('fecha', null, Array('format'=>'d/M/y'))
            ->add('detalle')
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
        $sqlh = false;
        $id   = null;
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        if($this->isGranted('ROLE_HPGD') and !$this->isGranted('ROLE_SUPER_ADMIN')){
            $id = $user->getHospital()->getId();
            $sqlh= true;
        }
        $form
            #->add('id')
            ->ifTrue($sqlh)
            ->add('hospital', EntityType::class, [
                'class' => Hospital::class,
                'choice_value' => 'id',
                'by_reference' => false,
                'multiple' => false,
                'expanded' => false,
                'required' => true,
                'query_builder' => function (EntityRepository $er) use ($id) : QueryBuilder {
                    return $er->createQueryBuilder('h')
                        ->Where('h.id = :id')
                        ->setParameter('id', $id);
                },
            ])
            ->ifEnd()
            ->ifFalse($sqlh)
            ->add('hospital', EntityType::class, [
                'class' => Hospital::class,
                'choice_value' => 'id',
                'by_reference' => false,
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'query_builder' => function (EntityRepository $er) : QueryBuilder {
                    return $er->createQueryBuilder('h')
                        ->Where('h.hpgd = 0');
                },
            ])
            ->ifEnd()
            ->add('importe')
            ->add('numero_expediente')
            ->add('fecha')
            ->add('tipo')
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('importe')
            ->add('numero_expediente')
            ->add('fecha')
            ->add('tipo')
            ;
    }
}
