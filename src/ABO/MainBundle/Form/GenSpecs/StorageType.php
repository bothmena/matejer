<?php

namespace ABO\MainBundle\Form\GenSpecs;

use ABO\MainBundle\Form\GenSpecs\GeneralSpecType as BaseType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StorageType extends BaseType {
    
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
            ->add('description',  TextareaType::class,array(
                'label' => 'matejer_main.description',
                'required' => true,
                'attr' => array(),
                'constraints'=>array(),
            ))
            ->add('one', IntegerType::class,array(
                'label' => 'matejer_genspecs.storage.one',
                'required' => true,
                'attr' => array(),
                'constraints'=>array(),
            ))
            ->add('two', IntegerType::class,array(
                'label' => 'matejer_genspecs.storage.two',
                'required' => true,
                'attr' => array(),
                'constraints'=>array(),
            ))
            ->add('three', IntegerType::class,array(
                'label' => 'matejer_genspecs.storage.three',
                'required' => true,
                'attr' => array(),
                'constraints'=>array(),
            ))
            ->add('four', ChoiceType::class,array(
                'label' => 'matejer_genspecs.storage.four',
                'required' => true,
                'attr' => array(),
                'constraints'=>array(),
            ))
            ->add('five', IntegerType::class,array(
                'label' => 'matejer_genspecs.storage.five',
                'required' => true,
                'attr' => array(),
                'constraints'=>array(),
            ))
            ->add('six', ChoiceType::class,array(
                'label' => 'matejer_genspecs.storage.six',
                'required' => true,
                'attr' => array(),
                'constraints'=>array(),
            ))
            ->add('seven', ChoiceType::class,array(
                'label' => 'matejer_genspecs.storage.seven',
                'required' => true,
                'attr' => array(),
                'constraints'=>array(),
            ))
            ->add('eight', IntegerType::class,array(
                'label' => 'matejer_genspecs.storage.eight',
                'required' => true,
                'attr' => array(),
                'constraints'=>array(),
            ))
            ->add('nine', IntegerType::class,array(
                'label' => 'matejer_genspecs.storage.nine',
                'required' => true,
                'attr' => array(),
                'constraints'=>array(),
            ))
            ->add('ten', IntegerType::class,array(
                'label' => 'matejer_genspecs.storage.ten',
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
            'csrf_token_id' => 'storage',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'abo_mainbundle_general_specs';
    }
}
