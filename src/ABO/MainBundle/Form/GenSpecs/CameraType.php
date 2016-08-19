<?php

namespace ABO\MainBundle\Form\GenSpecs;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CameraType extends AbstractType {
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        parent::buildForm($builder, array(
            'required'=>false,
            'constraints'=>array()
        ));
        
        $builder
            ->add('description',TextareaType::class,array(
                'label' => 'matejer_main.description',
                'required' => true,
                'attr' => array(),
                'constraints'=>array(),
            ))
            ->add('one',IntegerType::class,array(
                'label' => 'matejer_genspecs.camera.one',
                'required' => true,
                'attr' => array(),
                'constraints'=>array(),
            ))
            ->add('two',IntegerType::class,array(
                'label' => 'matejer_genspecs.camera.two',
                'required' => true,
                'attr' => array(),
                'constraints'=>array(),
            ))
            ->add('three',IntegerType::class,array(
                'label' => 'matejer_genspecs.camera.three',
                'required' => true,
                'attr' => array(),
                'constraints'=>array(),
            ))
            ->add('four',ChoiceType::class,array(
                'label' => 'matejer_genspecs.camera.four',
                'required' => true,
                'attr' => array(),
                'constraints'=>array(),
            ))
            ->add('five',IntegerType::class,array(
                'label' => 'matejer_genspecs.camera.five',
                'required' => true,
                'attr' => array(),
                'constraints'=>array(),
            ))
            ->add('six',ChoiceType::class,array(
                'label' => 'matejer_genspecs.camera.six',
                'required' => true,
                'attr' => array(),
                'constraints'=>array(),
            ))
            ->add('seven',ChoiceType::class,array(
                'label' => 'matejer_genspecs.camera.seven',
                'required' => true,
                'attr' => array(),
                'constraints'=>array(),
            ))
            ->add('eight',IntegerType::class,array(
                'label' => 'matejer_genspecs.camera.eight',
                'required' => true,
                'attr' => array(),
                'constraints'=>array(),
            ))
            ->add('nine',IntegerType::class,array(
                'label' => 'matejer_genspecs.camera.nine',
                'required' => true,
                'attr' => array(),
                'constraints'=>array(),
            ))
            ->add('ten',IntegerType::class,array(
                'label' => 'matejer_genspecs.camera.ten',
                'required' => true,
                'attr' => array(),
                'constraints'=>array(),
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {

        $resolver->setDefaults(array(
            'data_class' => 'ABO\MainBundle\Entity\GeneralSpec',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'camera',
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'abo_mainbundle_general_specs';
    }
}
