<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Hospital;
use App\Entity\Nomencla;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use App\Entity\Servicios;
use App\Entity\Factura;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

final class ItemPrefacturacionAdmin extends AbstractAdmin
{

    public function getParentAssociationMapping()
    {
        $em = $this->modelManager->getEntityManager('App\Entity\ItemPrefacturacion');
        $className = $em->getClassMetadata(get_class($this->getParent()->getObject($this->getParent()->getRequest()->get('id'))))->getTableName();

        switch ($className)
        {
            case 'factura':
                return 'id_factura_FK';
                break;

            case 'anexoii':
                return 'Num_Anexo';
                break;

            default:
                return strtolower( $className );
                break;
        }
        return strtolower( $className );
    }
    /*
    
    public function  configure(){
        $this->parentAssociationMapping = 'id_factura_FK';
    }

    */




    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('numAnexo')
            ->add('codservFk')
            ->add('nomencla')
            ->add('cantidad')
            ->add('precio')
            ->add('reparto')
            #->add('idFacturaFk')
            ->add('estadoFactura')
            ->add('estadoPago')
            ->add('estadoItem')
            ->add('montoPago')
            ->add('cuotaId')
            ->add('codservFkm')
            ->add('estadoDebito')
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            #->add('Num_Anexo')
            ->add('codservFk.descripcionServicio',null,['label' => 'Servicio'])
            #->add('idNomencladorFk')
            ->add('cantidad')
            ->add('precio')
            #->add('reparto')
            ->add('id_Factura_Fk.numeroCompleto', null, ['label' => 'Factura'])
            #->add('estadoFactura')
            ->add('estadoPago', null, ['label' => 'Pagado?'])
            #->add('estadoItem')
            #->add('montoPago')
            #->add('cuotaId')
            #->add('codservFkm')
            ->add('estadoDebito', null, ['label' => 'Debitado?'])
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    #'edit' => [],
                    #'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $estado = false;
        $disabled = '';
        $codh = null;
        $list = true;
        if($this->isGranted('ROLE_AUTOGESTION') or $this->isGranted('ROLE_USER_HOSPITAL')):
            $list = false;
        else:
            $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
            $codh = $user->getHospital()->getId();
        endif;

        if ($this->getSubject()->getEstadoPago() == 1 or $this->getSubject()->getNumAnexo()->getCerrado() == 1):
            $estado = true;
            $disabled = 'disabled';
        endif;

        $form
            #->add('id')
            ->ifTrue($list)
            ->add('codserv_Fk', EntityType::class,
                ['class' => Servicios::class,
                    'choice_value' => 'codserv',
                    'query_builder' => function (EntityRepository $er) use ($codh): QueryBuilder {
                        return $er->createQueryBuilder('s')
                            ->where('s.hospital = (:codh)')
                            ->orderBy('s.descripcionServicio', 'ASC')
                            ->setParameter('codh',$codh);
                    },
                    'choice_label' => function (Servicios $s = null) {
                        return null === $s ? '' : $s->getDescripcionServicio();
                    },
                    'label' => 'Servicio',
                    'disabled' => $estado,

                ])
            ->ifEnd()
            ->ifFalse($list)
            ->add('codserv_Fk', EntityType::class,
                ['class' => Servicios::class,
                    'choice_value' => 'codserv',
                    'query_builder' => function (EntityRepository $er) : QueryBuilder {
                        return $er->createQueryBuilder('s')
                            ->where('s.hospital is null')
                            ->orderBy('s.descripcionServicio', 'ASC');
                    },
                    'choice_label' => function (Servicios $s = null) {
                        return null === $s ? '' : $s->getDescripcionServicio();
                    },
                    'label' => 'Servicio',
                    'disabled' => $estado,

                ])
            ->ifEnd()
            #, ModelListType::class, array(
            #    'by_reference' => false,'btn_edit' => false,'btn_delete' => false,'btn_add' => false, 'label' => 'Servicio'
            #))
            /*->add('nomencla', EntityType::class,
                ['class' => Nomencla::class,
                #'choice_value' => 'getTemaArancel',
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                  return $er->createQueryBuilder('n')
                        ->where('n.estado = 1')
                        ->orderBy('n.tema', 'ASC');
                },
                'label' => 'Nomenclador',
                'disabled' => $estado

            ])*/
            ->ifFalse($estado)
                ->add('nomencla', ModelListType::class, ['btn_add' => false, 'btn_edit' => false])
            ->ifEnd()
            ->ifTrue($estado)
                ->add('nomencla', TextType::class, ['disabled' => $disabled])
            ->ifEnd()
            ->add('cantidad', null,['disabled' => $disabled])
            #->add('precio', null, ['disabled' => true])
            #->add('precio')
            #->add('reparto')
            #->add('idFacturaFk')
            #->add('estadoFactura')
            #->add('estadoPago', HiddenType::class)
            #->add('estadoItem')
            #->add('montoPago')
            #->add('cuotaId', HiddenType::class)
            #->add('codservFkm')
            #->add('estadoDebito', HiddenType::class)
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('numAnexo')
            ->add('codservFk', null, ['label' => 'Servicio'])
            ->add('idNomencladorFk', null, ['label' => 'Nomenclador'])
            ->add('cantidad')
            ->add('precio')
            ->add('reparto')
            ->add('idFacturaFk', null, ['label' => 'Factura'])
            ->add('estadoFactura')
            ->add('estadoPago')
            ->add('estadoItem')
            ->add('montoPago')
            ->add('cuotaId')
            ->add('codservFkm')
            ->add('estadoDebito')
            ;
    }


    public function id_factura_FK()
    {
            $admin = $this->isChild() ? $this->getParent()->getSubject() : $this;
            return $admin;
    }   

    public function prePersist($object)
    {

    }


}
