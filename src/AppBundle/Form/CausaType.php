<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CausaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            'data_class' => 'AppBundle\Entity\Causa'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_causa';
    }
}
