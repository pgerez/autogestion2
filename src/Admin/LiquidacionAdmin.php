<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Cuota;
use App\Entity\Hospital;
use App\Entity\Liquidacion;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use phpDocumentor\Reflection\Types\This;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\DatePickerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

final class LiquidacionAdmin extends AbstractAdmin
{

    public function getBatchActions()
    {
        $actions = parent::getBatchActions();
        unset($actions['delete']);

        return $actions;
    }
    public function createQuery($context = 'list')
    {
        $arrayHpgd = $this->getModelManager()->getEntityManager(Hospital::class)->getRepository(Hospital::class)->arrayHpgd();
        $query = parent::createQuery($context);
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        if ($this->isGranted('ROLE_AUTOGESTION')):
            $query
                #->leftJoin($query->getRootAlias()[0].'.hospital', 'h', 'WITH', 'h.hpgd is null')
                ->where($query->getRootAlias()[0].".hospital NOT IN (:array)")
                ->orWhere($query->getRootAlias()[0].".hospital is null")
                ->setParameter('array',$arrayHpgd);
        elseif ($this->isGranted('ROLE_HPGD')):
            $query
                #->join($query->getRootAlias()[0].'.hospitalId', 'h', 'WITH', $query->getRootAlias()[0].'.hospitalId = h.id')
                ->where($query->getRootAlias()[0].".hospital = ".$user->getHospital()->getId());
        else:
            $query
                #->Where($query->getRootAlias()[0].".hospital  ".$user->getHospital()->getId())
                ->where($query->getRootAlias()[0].".hospital NOT IN (:array)")
                ->andWhere($query->getRootAlias()[0].".fechaDesde >= '2023-12-30'")
                ->orWhere($query->getRootAlias()[0].".hospital is null")
                ->setParameter('array',$arrayHpgd);
        endif;
        return $query;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('listitems');
        $collection->add('procItems');
        $collection->remove('edit');
        #$estimulo = $this->getSubject() ? $this->getSubject()->getEstimulos() : false;
        #if($estimulo or !$this->isGranted('ROLE_SUPER_ADMIN')):
        #    $collection->remove('edit');
        #endif;
    }

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
            ->add('fechaDesde', null, Array('label'=>'Desde', 'format'=>'d/m/y'))
            ->add('fechaHasta',null, Array('label'=>'Hasta', 'format'=>'d/m/y'))
            #->add('observacion')
            #->add('obrasocial')
            #->add('hospital')
            #->add('acreditar')
            ->add('expedienteNum')
            ->add('expedienteCod')
            ->add('expedienteAnio')
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => ['template' => 'liquidacion/cuotas.html.twig'],
                    'estimulo' => ['template' => 'liquidacion/estimulo.html.twig'],
                    #'edit' => ['template' => 'liquidacion/edit.html.twig'],
                    'delete' => ['template' => 'liquidacion/delete.html.twig'],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $disabled = false;
        $sql      = false;
        $id       = null;
        if(count($this->getSubject()->getCuotas()) > 0):
                $disabled = true;
        endif;

        if($this->isGranted('ROLE_HPGD') and !$this->isGranted('ROLE_SUPER_ADMIN')){
            $id = $user->getHospital()->getId();
            $sql= true;
        }

        $form
            #->add('observacion')
            ->add('obrasocial', null, ['disabled' => $disabled])
            ->ifTrue($sql)
                ->add('hospital', EntityType::class, [
                    'class' => Hospital::class,
                    'choice_value' => 'id',
                    'by_reference' => false,
                    'multiple' => false,
                    'disabled' => $disabled,
                    'expanded' => false,
                    'required' => true,
                    'query_builder' => function (EntityRepository $er) use ($id) : QueryBuilder {
                            return $er->createQueryBuilder('h')
                                ->Where('h.id = :id')
                                ->setParameter('id', $id);
                    },
                ])
            ->ifEnd()
            ->ifFalse($sql)
                ->add('hospital', EntityType::class, [
                    'class' => Hospital::class,
                    'choice_value' => 'id',
                    'by_reference' => false,
                    'multiple' => false,
                    'disabled' => $disabled,
                    'expanded' => false,
                    'required' => false,
                    'query_builder' => function (EntityRepository $er) : QueryBuilder {
                            return $er->createQueryBuilder('h')
                                ->Where('h.hpgd = 0');
                    },
                ])
            ->ifEnd()
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
            ;
    }

    public function postPersist($object)
    {
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $fd = $object->getFechaDesde()->format('Y-m-d');
        $fh = $object->getFechaHasta()->format('Y-m-d');
        $em = $this->getModelManager()->getEntityManager(Cuota::class);
        if($this->isGranted('ROLE_HPGD')):
            $h = $user->getHospital()->getId();
        else:
            $h = null;
        endif;
        $r = $em->getRepository(Cuota::class)->updateByFechaLiquidacion($fd,$fh,$object->getId(),$h);
        #$this->addFlash('sonata_flash_success', 'Se actualizaron '.$r.' registros...');


    }

    public function preRemove($object)
    {
        $em = $this->getModelManager()->getEntityManager(Cuota::class);
        foreach ($object->getCuotas() as $cuota):
            $cuota->setLiquidacion(null);
            $em->persist($cuota);
            $em->flush();
        endforeach;

    }

}
