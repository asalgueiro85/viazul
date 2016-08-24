<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConfiguracionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cuenta', 'money', array(
                'currency' => null,
                'invalid_message' => 'Debe ser un valor positivo',
//                'read_only' => true,
                'attr' => array(
                    'placeholder' => 'Cuenta',
                    'class' => 'form-control'
                )
            ))->add('fondo', 'money', array(
                'currency' => null,
                'invalid_message' => 'Debe ser un valor positivo',
//                'read_only' => true,
                'attr' => array(
                    'placeholder' => 'Fondo de Viazul',
                    'class' => 'form-control'
                )
            ))->add('trans', 'money', array(
                'currency' => null,
                'invalid_message' => 'Debe ser un valor positivo',
                'attr' => array(
                    'placeholder' => 'Transferencia',
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
            'data_class' => 'AppBundle\Entity\Configuracion'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_configuracion';
    }
}
