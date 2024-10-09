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
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

final class ServiciosAdmin extends AbstractAdmin
{

    public function createQuery($context = 'list')
    {
        $arrayHpgd = $this->getModelManager()->getEntityManager(Hospital::class)->getRepository(Hospital::class)->arrayHpgd();
        $query = parent::createQuery($context);
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        if ($this->isGranted('ROLE_AUTOGESTION')):
            $query
                ->where($query->getRootAlias()[0].".hospital not in (:array)")
                ->orWhere($query->getRootAlias()[0].".hospital is null")
                ->setParameter('array',$arrayHpgd);
        elseif ($this->isGranted('ROLE_HPGD')):
            $query
                ->where($query->getRootAlias()[0].".hospital = ".$user->getHospital()->getId());
        else:
            $query
                ->where($query->getRootAlias()[0].".hospital not in (:array)")
                ->orWhere($query->getRootAlias()[0].".hospital is null")
                ->setParameter('array',$arrayHpgd);
        endif;
        return $query;
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('codserv')
            ->add('descripcionServicio')
            ->add('codEntero')
            ->add('codRango')
            ->add('codFijo')
            ->add('estado')
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('codserv')
            ->add('descripcionServicio')
            ->add('codEntero')
            ->add('codRango')
            ->add('codFijo')
            ->add('estado')
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
        $list = true;
        $codh = '';
        if($this->isGranted('ROLE_AUTOGESTION') or $this->isGranted('ROLE_SUPER_ADMIN')):
            $codh = '';
            $list = false;
        else:
            $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
            $codh = $user->getHospital()->getId();
        endif;

        $form
            ->ifTrue($list)
            ->add('hospital', EntityType::class,
                ['class' => Hospital::class,
                    'query_builder' => function (EntityRepository $er) use ($codh): QueryBuilder {
                        return $er->createQueryBuilder('h')
                            ->where('h.id = '.$codh);
                    },
                    'label' => 'Hospital',

                ])
            ->ifEnd()
            ->ifFalse($list)
            ->add('hospital', EntityType::class,
                ['class' => Hospital::class,
                    'query_builder' => function (EntityRepository $er) : QueryBuilder {
                        return $er->createQueryBuilder('h')
                            ->where('h.hpgd = 0');
                    },
                    'label' => 'Hospital',

                ])
            ->ifEnd()
            ->add('descripcionServicio', null, ['label' => 'Descripcion', 'required' => true])
            ->add('codEntero', null, ['label' => 'Codigo', 'required' => true])
            ->add('codRango')
            ->add('codFijo')
            ->add('estado')
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('codserv')
            ->add('descripcionServicio')
            ->add('codEntero')
            ->add('codRango')
            ->add('codFijo')
            ->add('estado')
            ;
    }
}
