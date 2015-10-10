<?php

namespace Curso\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', 'text', array('required'=>true, 'invalid_message' => 'Necesitamos un nombre'))
            ->add('precio', 'integer', array('required'=>true, 'invalid_message' => '¿Seguro que es gratis?'))
            ->add('Guardar', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Curso\MainBundle\Entity\Producto'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'curso_mainbundle_producto';
    }
}
