<?php

namespace ABO\MainBundle\Form\GenSpecs;

use ABO\MainBundle\Form\GenSpecs\GeneralSpecType as BaseType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class TelevisionType extends BaseType {
    
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
            ->add('one',  NumberType::class,array(
                'label' => 'matejer_genspecs.Television.one.label',
                'required' => true,
                'attr' => array(
                    'data-render' =>  'addon',
                    'class' =>'form-control',
                    'min' =>'10',
                    'max' =>'150',
                    'step' =>'0.1',
                    'aria-describedby' => 'addon-one',
                    'data-addon'=>  'Insh',
                ),
                'constraints'=>array(),
            ))
            ->add('two',IntegerType::class,array(
                'label' => 'matejer_genspecs.Television.two_three.label',
                'required' => true,
                'attr' => array(
                    'data-render'=>  'first-half',
                    'placeholder' => '1920',
                    'class'=>'form-control',
                    'min'=>'320',
                    'max'=>'7680',
                    'aria-describedby' => 'addon-two',
                    'data-addon'=>  'matejer_genspecs.Television.two.label',
                ),
                'constraints'=>array(),
            ))
            ->add('three',IntegerType::class,array(
                'label' => 'matejer_genspecs.Television.two_three.label',
                'required' => true,
                'attr' => array(
                    'data-render'=>  'second-half',
                    'placeholder' => '1080',
                    'class'=>'form-control',
                    'min'=>'240',
                    'max'=>'4320',
                    'aria-describedby' => 'addon-three',
                    'data-addon'=>  'matejer_genspecs.Television.three.label',
                ),
                'constraints'=>array(),
            ))
            ->add('four',ChoiceType::class,array(
                'label' => 'matejer_genspecs.Television.four.label',
                'required' => true,
                'choices'=>array(
                    'matejer_genspecs.Television.four.values.lcd'=>'lcd',
                    'matejer_genspecs.Television.four.values.led'=>'led',
                    'matejer_genspecs.Television.four.values.oled'=>'oled',
                    'matejer_genspecs.Television.four.values.quant'=>'quant',
                    'matejer_genspecs.Television.four.values.plasma'=>'plasma',
                ),
                'attr' => array(
                    'class'=>'form-control',
                ),
                'constraints'=>array(),
            ))
            ->add('ten',ChoiceType::class,array(
                'label' => 'matejer_genspecs.Television.ten.label',
                'required' => true,
                'choices'=> array(
                    '1:1'=>'1:1', 
                    '6:5 (1.20:1)'=>'6:5 (1.20:1)', 
                    '5:4 (1.25:1)'=>'5:4 (1.25:1)', 
                    '4:3 (1.33:1)'=>'4:3 (1.33:1)', 
                    '11:8 (1.375:1)'=>'11:8 (1.375:1)', 
                    '1.41:1'=>'1.41:1',
                    '1.43:1'=>'1.43:1', 
                    '3:2 (1.5:1)'=>'3:2 (1.5:1)', 
                    '16:10 - 8:5 (1.6:1)'=>'16:10 - 8:5 (1.6:1)', 
                    '16.18:10 (1.6180:1)'=>'16.18:10 (1.6180:1)', 
                    '5:3 (1.6667:1)'=>'5:3 (1.6667:1)', 
                    '16:9 (1.77:1 / 1.78:1)'=>'16:9 (1.77:1 / 1.78:1)',
                    '1.85:1'=>'1.85:1', 
                    '2.35:1 / 2.39:1'=>'2.35:1 / 2.39:1', 
                    '2.414:1'=>'2.414:1',
                    '21:9 (2.33:1)'=>'21:9 (2.33:1)',
                ),
                'preferred_choices'=> array('16:9 (1.77:1 / 1.78:1)', '4:3 (1.33:1)', '21:9 (2.33:1)'),
                'attr' => array(
                    'class'=>'form-control',
                ),
                'choices_as_values' => true,
                'constraints' => new Choice(array(
                    'choices' => array('1:1', '6:5 (1.20:1)', '5:4 (1.25:1)', '4:3 (1.33:1)', '11:8 (1.375:1)',
                        '1.41:1', '1.43:1', '3:2 (1.5:1)', '16:10 - 8:5 (1.6:1)', '16.18:10 (1.6180:1)',
                        '5:3 (1.6667:1)', '16:9 (1.77:1 / 1.78:1)', '1.85:1', '2.35:1 / 2.39:1', '2.414:1' ),
                ))
            ))
            ->add('five',IntegerType::class,array(
                'label' => 'matejer_genspecs.Television.five.label',
                'required' => true,
                'attr' => array(
                    'data-render'=>  'addon',
                    'class'=>'form-control',
                    'min'=>'50',
                    'max'=>'2000',
                    'aria-describedby' => 'addon-five',
                    'data-addon'=>  'Hz',
                ),
                'constraints'=>array(),
            ))
            ->add('six',ChoiceType::class,array(
                'label' => 'matejer_genspecs.Television.six.label',
                'required' => true,
                'expanded' => true,
                'multiple' => false,
                'attr' => array(
                    'data-render'=>'radio-inline',
                ),
                'data'=>'0',
                'choice_attr'=>[['class'=>'pull-left'],['class'=>'pull-left']],
                'choices' => array(
                    'matejer_main.yes'=>'1',
                    'matejer_main.no'=>'0',
                ),
                'constraints'=>array(),
            ))
            ->add('seven',ChoiceType::class,array(
                'label' => 'matejer_genspecs.Television.seven.label',
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
                'constraints'=>array(),
            ))
            ->add('eight',IntegerType::class,array(
                'label' => 'matejer_genspecs.Television.eight.label',
                'required' => true,
                'attr' => array(
                    'class'=>'form-control',
                    'min'=>'0',
                    'max'=>'15',
                ),
                'constraints'=>array(),
            ))
            ->add('nine',IntegerType::class,array(
                'label' => 'matejer_genspecs.Television.nine.label',
                'required' => true,
                'attr' => array(
                    'class'=>'form-control',
                    'min'=>'0',
                    'max'=>'15',
                ),
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
            'csrf_token_id' => 'television',
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
