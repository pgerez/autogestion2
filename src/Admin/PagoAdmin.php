<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Estado;
use App\Entity\Factura;
use App\Entity\ObrasSociales;
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
            ->add('hospitalId')
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
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $true = false;
        $trueFacturas = false;
        $disabled = false;
        $sql = false;
        $estadoId = '';
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
                ->add('hospitalId', null, ['label' => 'Hospital'])
                ->add('obrasSocialesCodOs', null, ['label' => 'Obra Social', 'required' => true])
                ->add('debito')
                ->add('fecha', DatePickerType::class, Array('label'=>'Fecha Carga', 'format'=>'d/M/y'))
                ->add('cantidad')
                ->add('observacion')
                ->add('sfGuardUserId', HiddenType::class, ['attr' => ['value' => $user->getId()]])
                ->add('monto')
                ->add('isSuperIntendencia', null, ['label' => 'Superintendencia'])
                ->add('notaCredito', null, ['label' => 'Nota de Credito'])
                ->add('judicial', null, ['label' => 'Por via Judicial'])
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
                        'query_builder' => function (EntityRepository $er) use ($sql,$estadoId) : QueryBuilder {
                            if(!$sql):
                            return $er->createQueryBuilder('f')
                                ->Where('f.codOs = :osid')
                                ->andWhere('f.pago is null')
                                ->andWhere('f.estadoId = :estadoId')
                                #->orWhere('f.estadoId = 13')
                                ->orWhere('f.pago = :pid')
                                ->setParameter('pid', $this->getSubject()->getId())
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
                                ->setParameter('osid', $this->getSubject()->getObrasSocialesCodOs()->getCodobra());
                            endif;
                        },
                        'choice_label' => function (Factura $f = null) {
                            return null === $f ? '': $f->getNumeroCompleto();
                        },
                    ])
                ->ifEnd()
            ->end()
            ->with('Cuotas')
                ->ifTrue($trueFacturas)
                    ->add('cuotas', CollectionType::class, [
                        'by_reference' => false,
                        'label' => false,
                        #'disabled' => $disabled,
                        #'btn_add' => $btn
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

    public function preUpdate($object)
    {
        $f = $this->getModelManager()->getEntityManager(Factura::class);
        $estado = $this->getModelManager()->getEntityManager(Estado::class)->getRepository(Estado::class)->find(3);
        if($object->getFacturas()):
            foreach ($object->getFacturas() as $factura):
                $factura->setEstadoId($estado);
                $f->persist($factura);
                $f->flush();
            endforeach;
        endif;
    }

}
