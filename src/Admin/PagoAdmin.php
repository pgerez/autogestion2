<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Estado;
use App\Entity\Factura;
use App\Entity\Hospital;
use App\Entity\ObrasSociales;
use Doctrine\ORM\Mapping\PreRemove;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\CollectionType;
use Sonata\Form\Type\DatePickerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class PagoAdmin extends AbstractAdmin
{

    public function  configure(){
        $this->setTemplate('edit', '/PagoAdmin/edit.html.twig');
    }

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
                ->where($query->getRootAlias()[0].".hospitalId NOT IN (:array)")
                ->orWhere($query->getRootAlias()[0].".hospitalId is null")
                ->setParameter('array',$arrayHpgd);
        elseif ($this->isGranted('ROLE_HPGD')):
            $query
                #->join($query->getRootAlias()[0].'.hospitalId', 'h', 'WITH', $query->getRootAlias()[0].'.hospitalId = h.id')
                ->where($query->getRootAlias()[0].".hospitalId = ".$user->getHospital()->getId());
        else:
            $query
                #->Where($query->getRootAlias()[0].".hospital  ".$user->getHospital()->getId())
                ->where($query->getRootAlias()[0].".hospitalId NOT IN (:array)")
                ->andWhere($query->getRootAlias()[0].".fechaDesde >= '2023-12-30'")
                #->orWhere($query->getRootAlias()[0].".hospitalId is null")
                ->setParameter('array',$arrayHpgd);
        endif;
        return $query;
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('debito')
            ->add('fecha')
            ->add('cantidad')
            ->add('observacion')
            ->add('obrasSocialesCodOs')
            ->add('sfGuardUserId')
            ->add('monto')
            ->add('isSuperIntendencia')
            ->add('notaCredito')
            ->add('hospitalId')
            ->add('descripcion')
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('debito')
            ->add('fecha')
            ->add('cantidad')
            ->add('observacion')
            ->add('obrasSocialesCodOs')
            ->add('sfGuardUserId')
            ->add('monto')
            ->add('isSuperIntendencia')
            ->add('notaCredito')
            ->add('hospitalId', null, ['label' => 'Hospital'])
            ->add('descripcion')
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
        $user           = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $true           = false;
        $trueFacturas   = false;
        $disabled       = false;
        $sql            = false;
        $sqlh           = false;
        $estadoId       = '';
        $id             = null;
        $required       = false;
        $arrayHpgd      = $this->getModelManager()->getEntityManager(Hospital::class)->getRepository(Hospital::class)->arrayHpgd();
        if($this->getSubject()->getId()):
            if($this->getSubject()->getJudicial()):
                $estadoId = 13;
            else:
                $estadoId = 1;
            endif;
            $true = true;
            $sql = $this->getSubject()->getHospitalId() ? true : false;
            if(count($this->getSubject()->getFacturas()) > 0):
                $trueFacturas = true;
            endif;
            if(count($this->getSubject()->getCuotas()) > 0):
                $disabled = true;
            endif;
        endif;

        if($this->isGranted('ROLE_HPGD') and !$this->isGranted('ROLE_SUPER_ADMIN')){
            $id = $user->getHospital()->getId();
            $sqlh= true;
        }

        $form
            ->with('Pago', ['class' => 'col-md-4', 'box_class' => 'box box-solid box-primary'])
            ->end()
            ->with('Facturas', ['class' => 'col-md-8', 'box_class' => 'box box-solid box-primary'])
            ->end()
            ->with('Cuotas', ['class' => 'col-md-8', 'box_class' => 'box box-solid box-primary'])
            ->end();

        $form
            ->with('Pago')
                #->add('id')
                ->ifTrue($sqlh)
                    ->add('hospitalId', EntityType::class, [
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
                ->ifFalse($sqlh)
                    ->add('hospitalId', EntityType::class, [
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
                ->add('obrasSocialesCodOs', null, ['label' => 'Obra Social', 'required' => true, 'disabled' => $disabled])
                ->add('debito')
                ->add('fecha', DatePickerType::class, Array('label'=>'Fecha Carga', 'format'=>'d/M/y'))
                ->add('cantidad')
                ->add('observacion')
                ->add('sfGuardUserId', HiddenType::class, ['attr' => ['value' => $user->getId()]])
                ->add('monto')
                ->add('isSuperIntendencia', null, ['label' => 'Superintendencia', 'disabled' => $trueFacturas])
                ->add('notaCredito', null, ['label' => 'Nota de Credito', 'disabled' => $trueFacturas])
                ->add('judicial', null, ['label' => 'Por via Judicial', 'disabled' => $trueFacturas])
                #->add('descripcion')
            ->end()
            ->with('Facturas')
                ->ifTrue($true)
                    ->add('facturas', EntityType::class, [
                        'class' => Factura::class,
                        #'choice_label' => 'digital_num',
                        'choice_value' => 'id_factura',
                        'by_reference' => false,
                        'multiple' => true,
                        'disabled' => $disabled,
                        'label' => false,
                        'expanded' => false,
                        'query_builder' => function (EntityRepository $er) use ($sql,$estadoId,$arrayHpgd) : QueryBuilder {
                            if(!$sql):
                            return $er->createQueryBuilder('f')
                                ->Where('f.codOs = :osid')
                                ->andWhere('f.pago is null')
                                ->andWhere('f.estadoId = :estadoId')
                                ->andWhere('f.hospitalId not in (:array)')
                                #->orWhere('f.estadoId = 13')
                                ->orWhere('f.pago = :pid')
                                ->setParameter('pid', $this->getSubject()->getId())
                                ->setParameter('array',$arrayHpgd)
                                ->setParameter('estadoId', $estadoId)
                                ->setParameter('osid', $this->getSubject()->getObrasSocialesCodOs()->getRowId());
                            else:
                            return $er->createQueryBuilder('f')
                                ->where('f.hospitalId = :hid')
                                ->andWhere('f.codOs = :osid')
                                ->andWhere('f.pago is null')
                                ->andWhere('f.estadoId = :estadoId')
                                #->orWhere('f.estadoId = 13')
                                ->orWhere('f.pago = :pid')
                                ->setParameter('estadoId', $estadoId)
                                ->setParameter('hid', $this->getSubject()->getHospitalId()->getId())
                                ->setParameter('pid', $this->getSubject()->getId())
                                ->setParameter('osid', $this->getSubject()->getObrasSocialesCodOs()->getRowId());
                            endif;
                        },
                        'choice_label' => function (Factura $f = null) {
                            return null === $f ? '': $f->getNumeroCompleto().' - $'.$f->getMontoFact();
                        },
                    ])
                ->ifEnd()
            ->end()
            ->with('Cuotas')
                ->ifTrue($trueFacturas)
                    ->add('cuotas', CollectionType::class, [
                        'by_reference' => false,
                        'label' => false,
                        #'disabled' => $trueFacturas,
                        #'btn_delete' => false
                        ],
                        [
                            'edit' => 'inline',
                            'inline' => 'table',
                            'sortable' => 'position',
                        ])
                ->ifEnd()
            ->end()
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('debito')
            ->add('fecha')
            ->add('cantidad')
            ->add('observacion')
            ->add('obrasSocialesCodOs')
            ->add('sfGuardUserId')
            ->add('monto')
            ->add('isSuperIntendencia')
            ->add('notaCredito')
            ->add('hospitalId')
            ->add('descripcion')
            ;
    }

    public function postPersist($object)
    {
        parent::postPersist($object); // TODO: Change the autogenerated stub
    }


    public function preUpdate($object)
    {
        $f = $this->getModelManager()->getEntityManager(Factura::class);
        $estado = $this->getModelManager()->getEntityManager(Estado::class)->getRepository(Estado::class)->find(3);
        $total  = 0;
        $debito = 0;
        if($object->getFacturas()):
            foreach ($object->getFacturas() as $factura):
                $factura->setEstadoId($estado);
                foreach ($factura->getItemPrefacturacions() as $item):
                    $total = $total + ($item->getPrecio()*$item->getCantidad());
                    $debito = $debito + $item->getMontoPago();
                endforeach;
                $factura->setDebito($debito);
                $f->persist($factura);
                $f->flush();
            endforeach;
        endif;
        $object->setMonto($total);
        $object->setDebito($debito);
    }

}
