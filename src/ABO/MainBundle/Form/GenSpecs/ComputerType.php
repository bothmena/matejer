<?php

namespace ABO\MainBundle\Form\GenSpecs;

use ABO\MainBundle\Form\GenSpecs\GeneralSpecType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;

class ComputerType extends GeneralSpecType {
    
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
                'label' => 'matejer_genspecs.Computer.one.label',
                'required' => true,
                'attr' => array(
                    'class' =>'form-control',
                ),
                'constraints'=>array(
                    new NotBlank(),
                ),
            ))
            ->add('two', IntegerType::class,array(
                'label' => 'matejer_genspecs.Computer.two.label',
                'required' => true,
                'scale'=>0,
                'attr' => array(
                    'data-render' => 'addon',
                    'class' =>'form-control',
                    'min' =>'1',
                    'max' =>'512',
                    'aria-describedby' => 'addon-two',
                    'data-addon'=>  'matejer_genspecs.Computer.two.unit',
                ),
                'constraints'=> array(
                    new GreaterThanOrEqual(array('value' => 1)),
                    new LessThanOrEqual(array('value' => 512)),
                ),
            ))
            ->add('three', TextType::class,array(
                'label' => 'matejer_genspecs.Computer.three.label',
                'required' => true,
                'attr' => array(
                    'class' =>'form-control',
                ),
                'constraints'=>array(
                    new NotBlank(),
                ),
            ))
            ->add('four', TextType::class,array(
                'label' => 'matejer_genspecs.Computer.four.label',
                'required' => true,
                'attr' => array(
                    'class' =>'form-control',
                ),
                'constraints'=>array(
                    new NotBlank(),
                ),
            ))
            ->add('five', TextType::class,array(
                'label' => 'matejer_genspecs.Computer.five.label',
                'required' => true,
                'attr' => array(
                    'class' =>'form-control',
                ),
            ))
            ->add('six', NumberType::class,array(
                'label' => 'matejer_genspecs.Computer.six.label',
                'required' => true,
                'scale'=>1,
                'attr' => array(
                    'data-render' =>  'addon',
                    'class' =>'form-control',
                    'min' =>'7',
                    'max' =>'65',
                    'step' =>'0.1',
                    'aria-describedby' => 'addon-six',
                    'data-addon'=>  'matejer_genspecs.Computer.six.unit',
                ),
                'constraints'=> array(
                    new GreaterThanOrEqual(array('value' => 7)),
                    new LessThanOrEqual(array('value' => 65)),
                ),
            ))
            ->add('seven', IntegerType::class,array(
                'label' => 'matejer_genspecs.Computer.seven_eight.label',
                'required' => false,
                'scale'=>0,
                'attr' => array(
                    'data-render'=>  'first-half',
                    'placeholder' => '1920',
                    'class'=>'form-control',
                    'min'=>'160',
                    'max'=>'7680',
                    'aria-describedby' => 'addon-seven',
                    'data-addon' => 'matejer_genspecs.Computer.seven.label',
                ),
                'constraints'=> array(
                    new GreaterThanOrEqual(array('value' => 160)),
                    new LessThanOrEqual(array('value' => 7680)),
                ),
            ))
            ->add('eight', IntegerType::class,array(
                'label' => 'matejer_genspecs.Computer.seven_eight.label',
                'required' => true,
                'scale'=>0,
                'attr' => array(
                    'data-render'=>  'second-half',
                    'placeholder' => '1080',
                    'class'=>'form-control',
                    'min'=>'120',
                    'max'=>'4320',
                    'aria-describedby' => 'addon-eight',
                    'data-addon'=>  'matejer_genspecs.Computer.eight.label',
                ),
                'constraints'=> array(
                    new GreaterThanOrEqual(array('value' => 120)),
                    new LessThanOrEqual(array('value' => 4320)),
                ),
            ))
            ->add('nine', ChoiceType::class,array(
                'label' => 'matejer_genspecs.Computer.nine.label',
                'required' => true,
                'expanded' => true,
                'multiple' => false,
                'choices' => array(
                    'matejer_main.yes'=>'1',
                    'matejer_main.no'=>'0',
                ),
                'data'=>'0',
                'choice_attr'=>[['class'=>'pull-left'],['class'=>'pull-left']],
                'attr' => array(
                    'data-render'=>'radio-inline',
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
            'csrf_token_id' => 'computer',
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix() {

        return 'abo_mainbundle_general_specs';
    }
}
