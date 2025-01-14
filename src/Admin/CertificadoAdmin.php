<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Certificado;
use App\Entity\Estado;
use App\Entity\Factura;
use App\Entity\Hospital;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\CollectionType;
use Sonata\Form\Type\DatePickerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Session\Session;

final class CertificadoAdmin extends AbstractAdmin
{

    public function createQuery($context = 'list')
    {
        $arrayHpgd = $this->getModelManager()->getEntityManager(Hospital::class)->getRepository(Hospital::class)->arrayHpgd();
        $query = parent::createQuery($context);
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        if ($this->isGranted('ROLE_AUTOGESTION')):
            $query
                #->leftJoin($query->getRootAlias()[0].'.hospital', 'h', 'WITH', 'h.hpgd is null')
                ->where($query->getRootAlias()[0].".hospital not in (:array)")
                ->orWhere($query->getRootAlias()[0].".hospital is null")
                ->setParameter('array',$arrayHpgd);
        elseif ($this->isGranted('ROLE_HPGD')):
            $query
                #->join($query->getRootAlias()[0].'.hospitalId', 'h', 'WITH', $query->getRootAlias()[0].'.hospitalId = h.id')
                ->where($query->getRootAlias()[0].".hospital = ".$user->getHospital()->getId());
        endif;
        return $query;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('pdf');
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('fecha')
            ->add('fecha_carga')
            ->add('monto')
            ->add('punto_venta')
            ->add('numero')
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('fecha')
            ->add('fecha_carga')
            ->add('monto')
            ->add('punto_venta')
            ->add('numero')
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'pdf' => ['template' => 'CertificadoAdmin/pdf.html.twig'],
                    'edit' => [],
                    #'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form): void
    {

        $true     = false;
        $disabled = false;
        $id       = '';
        if($this->getSubject()->getId()):
            $true = true;
            $id = $this->getSubject()->getId();
            $session = new Session();
            $session->set('os',$this->getSubject()->getObraSocial()->getRowId());
            if($this->getSubject()->getEstado() == 1):
                $disabled = true;
            endif;
        endif;

        $form
            ->with('Certificado', ['class' => 'col-md-4', 'box_class' => 'box box-solid box-primary'])
            ->end()
            ->with('Facturas', ['class' => 'col-md-8', 'box_class' => 'box box-solid box-primary'])
            ->end();


        $form
            ->with('Certificado')
                #->add('hospital', HiddenType::class)
                ->add('obraSocial', null, ['required' => true])
                ->add('fecha',DatePickerType::class, Array('label'=>'Fecha', 'format'=>'d/M/y'))
                ->add('fecha_carga', DatePickerType::class, Array('label'=>'Fecha Carga', 'format'=>'d/M/y'))
                ->add('monto', null, ['disabled' => true])
                ->add('punto_venta',null, ['disabled' => true])
                ->add('numero',null, ['disabled' => true])
            ->end()
            ->with('Facturas')
                ->ifTrue($true)
                    #->add('certificadoFacturas', CollectionType::class, [
                    #        'by_reference' => false,
                    #        'label' => false,
                    #        #'disabled' => $disabled,
                    #        #'btn_add' => false
                    #    ],
                    #    [
                    #        'edit' => 'inline',
                    #        'inline' => 'table',
                    #        'sortable' => 'position',
                    #    ])
                    ->add('facturas', EntityType::class, [
                        'class' => Factura::class,
                        #'choice_label' => 'digital_num',
                        'choice_value' => 'id_factura',
                        'by_reference' => false,
                        'multiple' => true,
                        'disabled' => $disabled,
                        'label' => false,
                        'expanded' => false,
                        'query_builder' => function (EntityRepository $er) use ($id) : QueryBuilder {
                                $sql = $this->getSubject()->getHospital() ? true : false;
                                $arrayHpgd      = $this->getModelManager()->getEntityManager(Hospital::class)->getRepository(Hospital::class)->arrayHpgd();
                                if(!$sql):
                                    return $er->createQueryBuilder('f')
                                        ->Where('f.codOs = :osid')
                                        ->andWhere('f.hospitalId not in (:array)')
                                        ->andWhere('f.estadoId = 1')
                                        ->orWhere('f.estadoId = 15')
                                        ->orWhere('f.certificado = :idc')
                                        ->setParameter('osid', $this->getSubject()->getObraSocial()->getRowId())
                                        ->setParameter('idc' , $id)
                                        ->setParameter('array',$arrayHpgd)
                                        ->addOrderBy('f.fechaEmision', 'asc');
                                else:
                                    return $er->createQueryBuilder('f')
                                        ->Where('f.codOs = :osid')
                                        ->andWhere('f.hospitalId = :hid')
                                        ->andWhere('f.estadoId = 1')
                                        ->orWhere('f.estadoId = 15')
                                        ->orWhere('f.certificado = :idc')
                                        ->setParameter('osid', $this->getSubject()->getObraSocial()->getRowId())
                                        ->setParameter('idc' , $id)
                                        ->setParameter('hid', $this->getSubject()->getHospital()->getId())
                                        ->addOrderBy('f.fechaEmision', 'asc');
                                endif;
                                },
                        'choice_label' => function (Factura $f = null) {
                            $dias = date('d-m-Y',strtotime( $f->getFechaEmision()->format('d-m-Y')."+ 60 day"));
                            $dias =  date_diff(date_create($dias),date_create())->days;
                            if($dias >= 60):
                                $dias = ' =>'.$dias.' Dias';
                            else:
                                $dias = '';
                            endif;
                            #$cantd = $f->getFechaEmision()->diff(date('now'));
                            return null === $f ? '': $f->getNumeroCompleto().' ('.$f->getFechaEmision()->format('d/m/Y').' '.$dias.') - $'.$f->getMontoFact();
                        },
                    ])
                ->ifEnd()
            ->end()
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('fecha')
            ->add('fecha_carga')
            ->add('monto')
            ->add('punto_venta')
            ->add('numero')
            ;
    }

    public function prePersist($object)
    {
        $user     = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        if($this->isGranted('ROLE_HPGD') and $user->getHospital()):
            $object->setHospital($user->getHospital());
        endif;
    }

    public function postPersist($object)
    {
        $cert = $this->getModelManager()->getEntityManager(Certificado::class);
        #echo var_dump($cert->getRepository(Certificado::class)->findOneBy([],['numero' => 'desc']));exit;
        $object->setNumero($cert->getRepository(Certificado::class)->findLastNumero());
        $cert->persist($object);
        $cert->flush();
    }

    public function preUpdate($object)
    {
        $f = $this->getModelManager()->getEntityManager(Factura::class);
        $estado = $this->getModelManager()->getEntityManager(Estado::class)->getRepository(Estado::class)->find(13);
        $total = 0;
        if($object->getFacturas()):
            foreach ($object->getFacturas() as $fa):
                $fa->setEstadoId($estado);
                $total += $fa->getMontoFact();
                $f->persist($fa);
                $f->flush();
            endforeach;
        endif;
        $object->setMonto($total);
    }
}
