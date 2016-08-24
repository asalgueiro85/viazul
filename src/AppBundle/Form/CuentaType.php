<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CuentaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('saldo', 'money', array(
                'attr' => array(
                    'placeholder' => 'Saldo',
                    'class' => 'form-control'
                )
            ))
            ->add('nombre', 'text', array(
                'attr' => array(
                    'placeholder' => 'Nombre',
                    'class' => 'form-control'
                )
            ))
            ->add('descripcion', 'textarea', array(
                'label' => 'Descripción',
                'attr' => array(
                    'placeholder' => 'Descripción',
                    'class' => 'form-control'
                )
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Cuenta'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_cuenta';
    }
}
