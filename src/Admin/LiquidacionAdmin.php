<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Cuota;
use App\Entity\Liquidacion;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\DatePickerType;

final class LiquidacionAdmin extends AbstractAdmin
{

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        if (!$this->isGranted('ROLE_AUTOGESTION') and !$this->isGranted('ROLE_SUPER_ADMIN')):
            $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
            $query
                #->join($query->getRootAlias()[0].'.hospitalId', 'h', 'WITH', $query->getRootAlias()[0].'.hospitalId = h.id')
                ->where($query->getRootAlias()[0].".fechaDesde >= '2023-12-30'");
        endif;

        return $query;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('listitems');
        $collection->add('procItems');
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
        $fd = $object->getFechaDesde('Y-m-d');
        $fh = $object->getFechaHasta('Y-m-d');
        $em = $this->getModelManager()->getEntityManager(Cuota::class);
        $r = $em->getRepository(Cuota::class)->updateByFechaLiquidacion($fd,$fh,$object->getId());


    }

}
