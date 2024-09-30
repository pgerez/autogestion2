<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Hospital;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\CollectionType;
use Sonata\Form\Type\DatePickerType;
use Sonata\AdminBundle\Route\RouteCollection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


final class AnexoiiAdmin extends AbstractAdmin
{

    protected $datagridValues = array(
        '_sort_order' => 'DESC',
        #'_sort_by' => 'foo',
    );

    public function getBatchActions()
    {
        $actions = parent::getBatchActions();
        unset($actions['delete']);

        return $actions;
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        if (!$this->isGranted('ROLE_AUTOGESTION') and !$this->isGranted('ROLE_SUPER_ADMIN') and !$this->isGranted('ROLE_USER_OS')):
            $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
            $query
                ->where($query->getRootAlias()[0].'.codH = '.$user->getHospital()->getId() )
                ->andWhere($query->getRootAlias()[0].'.sistema = 1');
        endif;

        if ($this->isGranted('ROLE_USER_OS') and !$this->isGranted('ROLE_SUPER_ADMIN') and !$this->isGranted('ROLE_AUTOGESTION')):
            $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
            $query
                ->where($query->getRootAlias()[0].'.codOs = '.$user->getObraSocial()->getRowId())
                ->andWhere($query->getRootAlias()[0].'.cerrado = 1')
                ->andWhere($query->getRootAlias()[0].'.sistema = 1');
        endif;

        return $query;
    }

    public function  configure(){
        $this->setTemplate('edit', '/AnexoiiAdmin/edit.html.twig');
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('buscarOs');
        $collection->add('renaper');
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('numAnexo', null, ['label' => 'Numero Anexo'])
            #->add('tipoDoc')
            ->add('documento')
            ->add('apeynom', null, ['label' => 'Apellido y Nombre'])
            #->add('fechaNac')
            #->add('sexo')
            ->add('codH', null, ['label' => 'Hospital'])
            ->add('codOs', null, ['label' => 'Obra Social'])
            #->add('numAfil')
            ->add('tipoBenef', null,  ['label' => 'Tipo de Atencion'], ChoiceType::class, [ 'choices' =>
                [
                'Ambulatorio' => 1,
                'Internacion' => 2,
                ]])
            #->add('parentesco')
            #->add('medicos')
            ->add('mesFacturacion', null, ['label' => 'Fecha Anexo'])
            #->add('codDev')
            ->add('estadoAnexo')
            ->add('fechaCarga', null, ['label' => 'Fecha de Carga'])
            #->add('horaCarga')
            #->add('mes')
            #->add('idEntrada')
            #->add('sfGuardUserId')
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $editableh  = false;
        $editableos = false;
        if($this->isGranted('ROLE_USER_AUTOGESTION') or $this->isGranted('ROLE_USER_HOSPITAL')):
            $editableh = true;
        endif;

        $list
            ->add('numAnexo', null, ['label' => 'Numero Anexo'])
            #->add('tipoDoc')
            ->add('documento')
            ->add('apeynom', null, ['label' => 'Apellido y Nombre'])
            #->add('fechaNac')
            #->add('sexo')
            ->add('codH', null, ['label' => 'Hospital'])
            ->add('codOs', null, ['label' => 'Obra Social'])
            #->add('numAfil')
            ->add('tipoAtencion', 'choice', [
                'choices' => [
                    ''  => 'Sin Tipo de Atencion',
                    '1' => 'Ambulatorio',
                    '2' => 'Internacion',
                ], 'label' => 'Tipo de Atencion'])
            #->add('parentesco')
            #->add('medicos')
            ->add('mesFacturacion', null, ['label' => 'Fecha Anexo', 'format'=>'d/m/y'])
            #->add('codDev')
            #->add('estadoAnexo')
            ->add('fechaCarga', null, ['label' => 'Fecha de Carga', 'format'=>'d/m/y'])
            ->add('fecha_egreso',null, ['label' => 'Fecha de Carga', 'format'=>'d/m/y'])
            #->add('horaCarga')
            #->add('idEntrada')
            #->add('sfGuardUserId')
            ->add('cerrado', null, ['editable' => true, 'template' => 'anexoii/list_cerrado.html.twig'])
            ->add('documentacion', null, ['editable' => true, 'template' => 'anexoii/list_documentacion.html.twig'])
            ->add('fecha_documentacion', null, ['label' => 'Fecha Doc', 'format'=>'d/m/y'])
            ->add('horaCarga', null, ['label' => 'Alerta', 'template' => 'anexoii/progress.html.twig']);
        if(!$this->isGranted('ROLE_USER_OS') or $this->isGranted('ROLE_USER_AUTOGESTION') or $this->isGranted('ROLE_USER_HOSPITAL')):
            $list
                ->add(ListMapper::NAME_ACTIONS, null, [
                    'actions' => [
                        'show' => [],
                        'edit' => ['template' => 'ItemAnexoiiAdmin/edit.html.twig'],
                        'delete' => ['template' => 'ItemAnexoiiAdmin/delete.html.twig'],
                    ],
                ]);
        else:
            $list
                ->add(ListMapper::NAME_ACTIONS, null, [
                    'actions' => [
                        'show' => [],
                    ],
            ]);
        endif;
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $disabled = false;
        $btn = 'Agregar nuevo';
        if($this->getSubject()->getNumAnexo()):
            if($this->getSubject()->getCerrado() == 1):
                $disabled = true;
                $btn = false;
            endif;
        endif;
        $list = true;

        if($this->isGranted('ROLE_AUTOGESTION') or $this->isGranted('ROLE_SUPER_ADMIN')):
            $codh = '';
            $list = false;
        else:
            $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
            $codh = $user->getHospital()->getId();
        endif;

        $form
            ->add('documento', null, ['disabled' => $disabled])
            ->add('apeynom', null, ['label' => 'Apellido y Nombre', 'disabled' => $disabled])
            ->ifTrue($list)
                ->add('codH', EntityType::class,
                    ['class' => Hospital::class,
                        'query_builder' => function (EntityRepository $er) use ($codh): QueryBuilder {
                            return $er->createQueryBuilder('h')
                                      ->where('h.id = '.$codh);
                        },
                        'label' => 'Hospital',
                        'disabled' => $disabled,

                    ])
            ->ifEnd()
            ->ifFalse($list)
                ->add('codH', EntityType::class,
                    ['class' => Hospital::class,
                        'query_builder' => function (EntityRepository $er) : QueryBuilder {
                            return $er->createQueryBuilder('h');
                        },
                        'label' => 'Hospital',
                        'disabled' => $disabled,

                    ])
            ->ifEnd()
            ->add('codOs', null, ['label' => 'Obra Social', 'disabled' => $disabled])
            #->add('numAfil')
            ->add('tipoAtencion', ChoiceType::class,
            ['choices' => [
                'Ambulatorio' => 1,
                'Internacion' => 2,
            ], 'label' => 'Tipo', 'disabled' => $disabled])
            #->add('fechaCarga', DatePickerType::class, Array('label'=>'Carga', 'format'=>'d/M/y', 'disabled' => $disabled))
            ->add('mesFacturacion', DatePickerType::class, Array('label'=>'Fecha Anexo', 'format'=>'d/M/y', 'disabled' => $disabled))
            ->add('fechaEgreso', DatePickerType::class, Array('label'=>'Fecha Egreso', 'format'=>'d/M/y', 'disabled' => $disabled, 'required' => false, 'help' => 'Solo para Internacion'))
            ->add('itemPrefacturacions', CollectionType::class, [
                                                'by_reference' => false,
                                                'label' => 'Prefacturacion',
                                                'disabled' => $disabled,
                                                'btn_add' => $btn,
                                                'required'   => true,

                                            ],
                                                [
                                                    'edit' => 'inline',
                                                    'inline' => 'table',
                                                    'sortable' => 'position',
                                                ])
            ->add('cie10', CollectionType::class, [
                                                'by_reference' => false,
                                                'label' => 'Diagnostico Cie10',
                                                'disabled' => $disabled,
                                                'btn_add' => $btn,
                                                'required' => true,
                                            ],
                                                [
                                                    'edit' => 'inline',
                                                    'inline' => 'table',
                                                    'sortable' => 'position',

                                                ])
            #->add('sfGuardUserId')
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('estadoAnexo', null, array('template' => 'anexoii/items.html.twig', 'label' => false))
            ;
    }

    public function prePersist($object)
    {
        $items = $object->getItemPrefacturacions();
        foreach ($items as $item):
            $value = $item->getNomencla()->getArancel();
            $item->setPrecio((string)$value);
        endforeach;
        $this->updateEstadoAnexoii($object);
    }

    public function preUpdate($object)
    {
        $items = $object->getItemPrefacturacions();
        foreach ($items as $item):
            $value = $item->getNomencla()->getArancel();
            $item->setPrecio((string)$value);
        endforeach;
        $this->updateEstadoAnexoii($object);
    }

    protected function updateEstadoAnexoii($object) {
        $post = $this->getRequest()->request;
        $finalize = $post->get('btn_update_and_list');
        $finalize2 = $post->get('btn_create_and_list');

        if (null !== $finalize or null !== $finalize2) {
            $object->setCerrado(true);
        }
    }
}
