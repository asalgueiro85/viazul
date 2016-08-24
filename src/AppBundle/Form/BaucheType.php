<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BaucheType extends AbstractType
{

    private $destinos;
    private $areas;

    function __construct($destinos, $areas)
    {
        foreach($areas as $area){
            $this->areas[$area->NombreArea] =  $area->NombreArea;
        }
        foreach($destinos as $destino){
            $this->destinos[$destino->NombreProvincia] =  $destino->NombreProvincia;
        }
    }


    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('codigo', 'text', array(
//                'label' => 'Código',
//                'read_only' => true,
//                'attr' => array(
//                    'placeholder' => 'Código',
//                    'class' => 'form-control'
//                )
//            ))
            ->add('importe', 'money', array(
                'currency' => null,
                'invalid_message' => 'Debe introducir un valor numérico positivo',
                'attr' => array(
                    'placeholder' => 'Importe',
                    'class' => 'form-control'
                )
            ))
            ->add('nombre', 'text', array(
                'attr' => array(
                    'placeholder' => 'Nombre',
                    'class' => 'form-control'
                )
            ))
            ->add('destino',  'choice', array(
                'choices' => $this->destinos
            ))
            ->add('area', 'choice', array(
                'label' => 'Área',
                'choices' => $this->areas
            ))
            ->add('dirArea', 'text', array(
                'label' => 'Director del Área',
                'attr' => array(
                    'placeholder' => 'Director del Área',
                    'class' => 'form-control'
                )
            ))
            ->add('fechaEmitido', 'date', array(
                'label' => 'Fecha de Emición',
                'required' => true,
                'widget' => 'single_text',
                'read_only' => true,
                'attr' => array(
                    'placeholder' => 'Fecha de Emición',
                    'class' => 'form-control'
                )
            ))

            ->add('estado', 'checkbox', array(
                'label' => 'Consumido',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Estado',
                    'class' => 'flat-red'
                )
            ))
            ->add('causa')

        ;


    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Bauche'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_bauche';
    }
}
