<?php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;


class FormFieldItemType extends HiddenType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired(array(
            'facturas',
            'idCuota'
        ));
    }

    public function getParent()
    {
        return 'Symfony\Component\Form\Extension\Core\Type\HiddenType';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }

    public function getBlockPrefix()
    {
        return 'formfield_item';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->setAttribute("facturas", $options['facturas']);
        $builder->setAttribute("idCuota", $options['idCuota']);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $options = array(
            'facturas'=> $form->getConfig()->getAttribute('facturas'),
            'idCuota'=> $form->getConfig()->getAttribute('idCuota'),
        );
        $view->vars['facturas'] = $form->getConfig()->getAttribute('facturas');
        $view->vars['idCuota'] = $form->getConfig()->getAttribute('idCuota');
    }

}

