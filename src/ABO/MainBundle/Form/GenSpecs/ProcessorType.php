<?php

namespace ABO\MainBundle\Form\GenSpecs;

use ABO\MainBundle\Form\GenSpecs\GeneralSpecType as BaseType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProcessorType extends BaseType {
    
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
            ->add('one', IntegerType::class,array(
                'label' => 'matejer_genspecs.Processor.one.label',
                'required' => true,
                'attr' => array(
                    'class'=>'form-control',
                    'min'=>'1',
                    'max'=>'50',
                ),
                'constraints'=>array(
                    new GreaterThanOrEqual(array('value' => 1)),
                    new LessThanOrEqual(array('value' => 50)),
                ),
            ))
            ->add('two', IntegerType::class,array(
                'label' => 'matejer_genspecs.Processor.two.label',
                'required' => true,
                'attr' => array(
                    'class'=>'form-control',
                    'min'=>'1',
                    'max'=>'50',
                ),
                'data'=>0,
                'constraints'=>array(
                    new GreaterThanOrEqual(array('value' => 0)),
                    new LessThanOrEqual(array('value' => 50)),
                ),
            ))
            ->add('three', NumberType::class,array(
                'label' => 'matejer_genspecs.Processor.three.label',
                'required' => true,
                'attr' => array(
                    'data-render'=>  'addon',
                    'class'=>'form-control',
                    'aria-describedby' => 'addon-three',
                    'data-addon'=>  'matejer_genspecs.Processor.three.unit',
                ),
                'constraints'=>array(
                    new GreaterThanOrEqual(array('value' => 0.1)),
                    new LessThanOrEqual(array('value' => 10)),
                ),
            ))
            ->add('four', IntegerType::class,array(
                'label' => 'matejer_genspecs.Processor.four.label',
                'required' => false,
                'attr' => array(
                    'data-render'=>  'addon',
                    'class'=>'form-control',
                    'min'=>'1',
                    'max'=>'100',
                    'aria-describedby' => 'addon-four',
                    'data-addon'=>  'matejer_genspecs.Processor.four.unit',
                ),
                'constraints'=>array(
                    new GreaterThanOrEqual(array('value' => 1)),
                    new LessThanOrEqual(array('value' => 100)),
                ),
            ))
            ->add('five', IntegerType::class,array(
                'label' => 'matejer_genspecs.Processor.five.label',
                'required' => false,
                'attr' => array(
                    'data-render'=>  'addon',
                    'class'=>'form-control',
                    'min'=>'0',
                    'max'=>'100',
                    'aria-describedby' => 'addon-five',
                    'data-addon'=>  'matejer_genspecs.Processor.five.unit',
                ),
                'constraints'=>array(
                    new GreaterThanOrEqual(array('value' => 0)),
                    new LessThanOrEqual(array('value' => 100)),
                ),
            ))
            ->add('six', TextType::class,array(
                'label' => 'matejer_genspecs.Processor.six.label',
                'required' => true,
                'attr' => array(
                    'class' =>'form-control',
                ),
                'constraints'=>array(
                    new NotBlank(),
                ),
            ))
            ->add('seven', TextType::class,array(
                'label' => 'matejer_genspecs.Processor.seven.label',
                'required' => false,
                'attr' => array(
                    'data-render'=>  'addon',
                    'class'=>'form-control',
                    'min'=>'1',
                    'max'=>'500',
                    'aria-describedby' => 'addon-seven',
                    'data-addon'=>  'matejer_genspecs.Processor.seven.unit',
                ),
                'constraints'=>array(
                    new GreaterThanOrEqual(array('value' => 1)),
                    new LessThanOrEqual(array('value' => 500)),
                ),
            ))
            ->add('eight', TextType::class,array(
                'label' => 'matejer_genspecs.Processor.eight.label',
                'required' => false,
                'attr' => array(
                    'class' =>'form-control',
                ),
                'constraints'=>array(
                    new NotBlank(),
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
            'csrf_token_id' => 'processor',
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
