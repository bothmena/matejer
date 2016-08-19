<?php

namespace ABO\MainBundle\Form\GenSpecs;

use ABO\MainBundle\Form\GenSpecs\GeneralSpecType as BaseType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;

class MotherboardType extends BaseType {
    
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
            ->remove('description')
            ->add('one', TextType::class,array(
                'label' => 'matejer_genspecs.Motherboard.one.label',
                'required' => true,
                'attr' => array(
                    'class' =>'form-control',
                ),
                'constraints'=>array(
                    new NotBlank(),
                ),
            ))
            ->add('two', TextType::class,array(
                'label' => 'matejer_genspecs.Motherboard.two.label',
                'required' => true,
                'attr' => array(
                    'class' =>'form-control',
                ),
                'constraints'=>array(
                    new NotBlank(),
                ),
            ))
            ->add('three', TextType::class,array(
                'label' => 'matejer_genspecs.Motherboard.three.label',
                'required' => true,
                'attr' => array(
                    'class' =>'form-control',
                ),
                'constraints'=>array(
                    new NotBlank(),
                ),
            ))
            ->add('four', TextType::class,array(
                'label' => 'matejer_genspecs.Motherboard.four.label',
                'required' => true,
                'attr' => array(
                    'class' =>'form-control',
                ),
                'constraints'=>array(
                    new NotBlank(),
                ),
            ))
            ->add('five',  IntegerType::class,array(
                'label' => 'matejer_genspecs.Motherboard.five.label',
                'required' => false,
                'scale'=>0,
                'attr' => array(
                    'data-render' => 'addon',
                    'class' =>'form-control',
                    'min' =>'1',
                    'max' =>'256',
                    'aria-describedby' => 'addon-five',
                    'data-addon'=>  'matejer_genspecs.Motherboard.five.unit',
                ),
                'constraints'=> array(
                    new GreaterThanOrEqual(array('value' => 1)),
                    new LessThanOrEqual(array('value' => 256)),
                ),
            ))
            ->add('six', TextType::class,array(
                'label' => 'matejer_genspecs.Motherboard.six.flabel',
                'required' => true,
                'attr' => array(
                    'class' =>'form-control',
                ),
                'constraints'=>array(
                    new NotBlank(),
                ),
            ))
            ->add('seven', TextType::class,array(
                'label' => 'matejer_genspecs.Motherboard.seven.flabel',
                'required' => true,
                'attr' => array(
                    'class' =>'form-control',
                ),
                'constraints'=>array(
                    new NotBlank(),
                ),
            ))
            ->add('eight', TextType::class,array(
                'label' => 'matejer_genspecs.Motherboard.eight.flabel',
                'required' => true,
                'attr' => array(
                    'class' =>'form-control',
                ),
                'constraints'=>array(
                    new NotBlank(),
                ),
            ))
            ->add('nine', TextType::class,array(
                'label' => 'matejer_genspecs.Motherboard.nine.flabel',
                'required' => false,
                'attr' => array(
                    'class' =>'form-control',
                ),
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
            'csrf_token_id' => 'motherboard',
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
