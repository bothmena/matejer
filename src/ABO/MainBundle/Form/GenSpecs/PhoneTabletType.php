<?php

namespace ABO\MainBundle\Form\GenSpecs;

use ABO\MainBundle\Form\GenSpecs\GeneralSpecType as BaseType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;

class PhoneTabletType extends BaseType {

    private $OSs = array(
        'Android'=>array(
            'matejer_genspecs.PhoneTablet.six.values.android_1_6' => 'android_1_6',
            'matejer_genspecs.PhoneTablet.six.values.android_2_1' => 'android_2_1',
            'matejer_genspecs.PhoneTablet.six.values.android_2_2' => 'android_2_2',
            'matejer_genspecs.PhoneTablet.six.values.android_2_3' => 'android_2_3',
            'matejer_genspecs.PhoneTablet.six.values.android_3_0' => 'android_3_0',
            'matejer_genspecs.PhoneTablet.six.values.android_4_0' => 'android_4_0',
            'matejer_genspecs.PhoneTablet.six.values.android_4_1' => 'android_4_1',
            'matejer_genspecs.PhoneTablet.six.values.android_4_4' => 'android_4_4',
            'matejer_genspecs.PhoneTablet.six.values.android_5_0' => 'android_5_0',
            'matejer_genspecs.PhoneTablet.six.values.android_6_0' => 'android_6_0',
        ),
        'iOS'=>array(
            'matejer_genspecs.PhoneTablet.six.values.ios_2' => 'ios_2',
            'matejer_genspecs.PhoneTablet.six.values.ios_3' => 'ios_3',
            'matejer_genspecs.PhoneTablet.six.values.ios_4' => 'ios_4',
            'matejer_genspecs.PhoneTablet.six.values.ios_5' => 'ios_5',
            'matejer_genspecs.PhoneTablet.six.values.ios_6' => 'ios_6',
            'matejer_genspecs.PhoneTablet.six.values.ios_7' => 'ios_7',
            'matejer_genspecs.PhoneTablet.six.values.ios_8' => 'ios_8',
            'matejer_genspecs.PhoneTablet.six.values.ios_9' => 'ios_9',
        ),
        'Windows Phone'=>array(
            'matejer_genspecs.PhoneTablet.six.values.wp_7' =>    'wp_7',
            'matejer_genspecs.PhoneTablet.six.values.wp_7_5' => 'wp_7_5',
            'matejer_genspecs.PhoneTablet.six.values.wp_7_8' => 'wp_7_8',
            'matejer_genspecs.PhoneTablet.six.values.wp_8' => 'wp_8',
            'matejer_genspecs.PhoneTablet.six.values.wp_8_1' => 'wp_8_1',
            'matejer_genspecs.PhoneTablet.six.values.wp_10' => 'wp_10',
        ),
    );

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
                'label' => 'matejer_genspecs.PhoneTablet.one.label',
                'required' => true,
                'attr' => array(
                    'class' =>'form-control',
                ),
                'constraints'=>array(
                    new NotBlank(),
                ),
            ))
            ->add('two', IntegerType::class,array(
                'label' => 'matejer_genspecs.PhoneTablet.two.label',
                'required' => true,
                'scale'=>0,
                'attr' => array(
                    'data-render' => 'addon',
                    'class' =>'form-control',
                    'min' =>'1',
                    'max' =>'8192',
                    'step' =>'1',
                    'aria-describedby' => 'addon-two',
                    'data-addon'=>  'matejer_genspecs.PhoneTablet.two.unit',
                ),
                'constraints'=> array(
                    new GreaterThanOrEqual(array('value' => 128)),
                    new LessThanOrEqual(array('value' => 8192)),
                ),
            ))
            ->add('three', NumberType::class,array(
                'label' => 'matejer_genspecs.PhoneTablet.three.label',
                'required' => true,
                'scale'=>1,
                'attr' => array(
                    'data-render' =>  'addon',
                    'class' =>'form-control',
                    'min' =>'1',
                    'max' =>'14',
                    'step' =>'0.1',
                    'aria-describedby' => 'addon-three',
                    'data-addon'=>  'matejer_genspecs.PhoneTablet.three.unit',
                ),
                'constraints'=> array(
                    new GreaterThanOrEqual(array('value' => 1)),
                    new LessThanOrEqual(array('value' => 14)),
                ),
            ))
            ->add('four', IntegerType::class,array(
                'label' => 'matejer_genspecs.PhoneTablet.four_five.label',
                'required' => false,
                'scale'=>0,
                'attr' => array(
                    'data-render'=>  'first-half',
                    'placeholder' => '1920',
                    'class'=>'form-control',
                    'min'=>'160',
                    'max'=>'7680',
                    'aria-describedby' => 'addon-four',
                    'data-addon' => 'matejer_genspecs.PhoneTablet.four.label',
                ),
                'constraints'=> array(
                    new GreaterThanOrEqual(array('value' => 160)),
                    new LessThanOrEqual(array('value' => 7680)),
                ),
            ))
            ->add('five', IntegerType::class,array(
                'label' => 'matejer_genspecs.PhoneTablet.two_three.label',
                'required' => true,
                'scale'=>0,
                'attr' => array(
                    'data-render'=>  'second-half',
                    'placeholder' => '1080',
                    'class'=>'form-control',
                    'min'=>'120',
                    'max'=>'4320',
                    'aria-describedby' => 'addon-five',
                    'data-addon'=>  'matejer_genspecs.PhoneTablet.five.label',
                ),
                'constraints'=> array(
                    new GreaterThanOrEqual(array('value' => 120)),
                    new LessThanOrEqual(array('value' => 4320)),
                ),
            ))
            ->add('six', ChoiceType::class,array(
                'label' => 'matejer_genspecs.PhoneTablet.six.label',
                'required' => true,
                'choices' => $this->OSs,
                'attr' => array(
                    'class'=>'form-control',
                ),
                'constraints'=>array(),
            ))
            ->add('seven', NumberType::class,array(
                'label' => 'matejer_genspecs.PhoneTablet.seven.label',
                'required' => true,
                'scale'=>1,
                'attr' => array(
                    'data-render' => 'addon',
                    'class' =>'form-control',
                    'min' =>'1',
                    'max' =>'120',
                    'step' =>'0.1',
                    'aria-describedby' => 'addon-seven',
                    'data-addon'=>  'matejer_genspecs.PhoneTablet.seven.unit',
                ),
                'constraints'=> array(
                    new GreaterThanOrEqual(array('value' => 0)),
                    new LessThanOrEqual(array('value' => 120)),
                ),
            ))
            ->add('eight', NumberType::class,array(
                'label' => 'matejer_genspecs.PhoneTablet.eight.label',
                'required' => true,
                'scale'=>1,
                'attr' => array(
                    'data-render' => 'addon',
                    'class' =>'form-control',
                    'min' =>'1',
                    'max' =>'120',
                    'step' =>'0.1',
                    'aria-describedby' => 'addon-eight',
                    'data-addon'=>  'matejer_genspecs.PhoneTablet.eight.unit',
                ),
                'constraints'=> array(
                    new GreaterThanOrEqual(array('value' => 0)),
                    new LessThanOrEqual(array('value' => 120)),
                ),
            ))
            ->add('nine', IntegerType::class,array(
                'label' => 'matejer_genspecs.PhoneTablet.nine.label',
                'required' => true,
                'attr' => array(
                    'data-render' => 'addon',
                    'class' =>'form-control',
                    'min' =>'1',
                    'max' =>'512',
                    'aria-describedby' => 'addon-nine',
                    'data-addon'=>  'matejer_genspecs.PhoneTablet.nine.unit',
                ),
                'constraints'=> array(
                    new GreaterThanOrEqual(array('value' => 1)),
                    new LessThanOrEqual(array('value' => 512)),
                ),
            ))
            ->add('ten', IntegerType::class,array(
                'label' => 'matejer_genspecs.PhoneTablet.ten.label',
                'required' => true,
                'attr' => array(
                    'data-render' => 'addon',
                    'class' =>'form-control',
                    'min' =>'0',
                    'max' =>'1024',
                    'aria-describedby' => 'addon-ten',
                    'data-addon'=>  'matejer_genspecs.PhoneTablet.ten.unit',
                ),
                'constraints'=> array(
                    new GreaterThanOrEqual(array('value' => 0)),
                    new LessThanOrEqual(array('value' => 1024)),
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
            'csrf_token_id' => 'phone_tablet',
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
