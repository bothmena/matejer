<?php

namespace ABO\MainBundle\Form\GenSpecs;

use ABO\MainBundle\Form\GenSpecs\GeneralSpecType as BaseType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;

class MonitorType extends BaseType {
    
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
            ->add('one', NumberType::class,array(
                'label' => 'matejer_genspecs.Monitor.one.label',
                'required' => true,
                'attr' => array(
                    'data-render' =>  'addon',
                    'class' =>'form-control',
                    'aria-describedby' => 'addon-one',
                    'data-addon'=>  'Insh',
                ),
                'constraints'=>array(
                    new GreaterThanOrEqual(array('value'=>8)),
                    new LessThanOrEqual(array('value'=>65)),
                ),
            ))
            ->add('two',IntegerType::class,array(
                'label' => 'matejer_genspecs.Monitor.two_three.label',
                'required' => true,
                'attr' => array(
                    'data-render'=>  'first-half',
                    'placeholder' => '1920',
                    'class'=>'form-control',
                    'min'=>'320',
                    'max'=>'7680',
                    'aria-describedby' => 'addon-two',
                    'data-addon'=>  'matejer_genspecs.Monitor.two.label',
                ),
                'constraints'=>array(
                    new GreaterThanOrEqual(array('value'=>320)),
                    new LessThanOrEqual(array('value'=>7680)),
                ),
            ))
            ->add('three',  IntegerType::class,array(
                'label' => 'matejer_genspecs.Monitor.two_three.label',
                'required' => true,
                'attr' => array(
                    'data-render'=>  'second-half',
                    'placeholder' => '1080',
                    'class'=>'form-control',
                    'min'=>'240',
                    'max'=>'4320',
                    'aria-describedby' => 'addon-three',
                    'data-addon'=>  'matejer_genspecs.Monitor.three.label',
                ),
                'constraints'=>array(
                    new GreaterThanOrEqual(array('value'=>240)),
                    new LessThanOrEqual(array('value'=>4320)),
                ),
            ))
            ->add('four', ChoiceType::class,array(
                'label' => 'matejer_genspecs.Monitor.four.label',
                'required' => true,
                'choices'=>array(
                    'matejer_genspecs.Monitor.four.values.lcd'=>'lcd',
                    'matejer_genspecs.Monitor.four.values.led'=>'led',
                    'matejer_genspecs.Monitor.four.values.oled'=>'oled',
                    'matejer_genspecs.Monitor.four.values.quant'=>'quant',
                    'matejer_genspecs.Monitor.four.values.plasma'=>'plasma',
                ),
                'attr' => array(
                    'class'=>'form-control',
                ),
                'constraints'=>array(
                    new Choice(array('choices'=>array('lcd', 'led', 'oled', 'quant', 'plasma', )))
                ),
            ))
            ->add('five',ChoiceType::class,array(
                'label' => 'matejer_genspecs.Monitor.five.label',
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
            ->add('six', IntegerType::class,array(
                'label' => 'matejer_genspecs.Monitor.six.label',
                'required' => true,
                'attr' => array(
                    'data-render' =>  'addon',
                    'class' =>'form-control',
                    'min' =>'1',
                    'aria-describedby' => 'addon-six',
                    'data-addon'=>  'matejer_genspecs.Monitor.six.unit',
                ),
                'constraints'=>array(
                    new GreaterThanOrEqual(array('value'=>1)),
                ),
            ))
            ->add('seven', IntegerType::class,array(
                'label' => 'matejer_genspecs.Monitor.seven.label',
                'required' => true,
                'attr' => array(
                    'data-render' =>  'addon',
                    'class' =>'form-control',
                    'min' =>'1',
                    'aria-describedby' => 'addon-seven',
                    'data-addon'=>  ':1',
                ),
                'constraints'=>array(
                    new GreaterThanOrEqual(array('value'=>1)),
                ),
            ))
            ->add('eight',IntegerType::class,array(
                'label' => 'matejer_genspecs.Monitor.eight.label',
                'required' => true,
                'attr' => array(
                    'data-render' =>  'addon',
                    'class' =>'form-control',
                    'min' =>'1',
                    'aria-describedby' => 'addon-eight',
                    'data-addon'=>  'matejer_genspecs.Monitor.eight.unit',
                ),
                'constraints'=>array(
                    new GreaterThanOrEqual(array('value'=>1)),
                ),
            ))
            ->add('nine', TextType::class,array(
                'label' => 'matejer_genspecs.Monitor.nine.label',
                'required' => true,
                'attr' => array(
                    'placeholder' => '1x HDMI#1x DisplayPort#1x VGA',
                    'class'=>'form-control',
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
            'csrf_token_id' => 'Monitor',
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
