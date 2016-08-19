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

class RamType extends BaseType {
    
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
            ->add('one',  IntegerType::class,array(
                'label' => 'matejer_genspecs.Ram.one.label',
                'required' => true,
                'scale'=>0,
                'attr' => array(
                    'class' =>'form-control',
                    'placeholder'=>'2',
                    'min' =>'1',
                    'max' =>'16',
                ),
                'constraints'=> array(
                    new GreaterThanOrEqual(array('value' => 1)),
                    new LessThanOrEqual(array('value' => 16)),
                ),
            ))
            ->add('two',  IntegerType::class,array(
                'label' => 'matejer_genspecs.Ram.two.label',
                'required' => true,
                'scale'=>0,
                'attr' => array(
                    'data-render' => 'addon',
                    'class' =>'form-control',
                    'placeholder'=>'4',
                    'min' =>'1',
                    'max' =>'64',
                    'aria-describedby' => 'addon-two',
                    'data-addon'=>  'matejer_genspecs.Ram.two.unit',
                ),
                'constraints'=> array(
                    new GreaterThanOrEqual(array('value' => 1)),
                    new LessThanOrEqual(array('value' => 64)),
                ),
            ))
            ->add('three',  IntegerType::class,array(
                'label' => 'matejer_genspecs.Ram.three.label',
                'required' => true,
                'scale'=>0,
                'attr' => array(
                    'data-render' => 'addon',
                    'class' =>'form-control',
                    'placeholder'=>'1600',
                    'min' =>'500',
                    'max' =>'10000',
                    'aria-describedby' => 'addon-three',
                    'data-addon'=>  'matejer_genspecs.Ram.three.unit',
                ),
                'constraints'=> array(
                    new GreaterThanOrEqual(array('value' => 500)),
                    new LessThanOrEqual(array('value' => 10000)),
                ),
            ))
            ->add('four',  TextType::class,array(
                'label' => 'matejer_genspecs.Computer.four.label',
                'required' => true,
                'attr' => array(
                    'class' =>'form-control',
                    'placeholder'=>'DDR3',
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
            'csrf_token_id' => 'ram',
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
