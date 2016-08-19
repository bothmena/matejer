<?php

namespace ABO\MainBundle\Form\GenSpecs;

use ABO\MainBundle\Form\GenSpecs\GeneralSpecType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;

class GraphicCardType extends GeneralSpecType {
    
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
            ->add('one',  TextType::class,array(
                'label' => 'matejer_genspecs.GraphicCard.one.label',
                'required' => true,
                'attr' => array(
                    'class' =>'form-control',
                    'placeholder'=>'Up to 1250 Mhz',
                ),
                'constraints'=>array(
                    new NotBlank(),
                ),
            ))
            ->add('two',TextType::class,array(
                'label' => 'matejer_genspecs.GraphicCard.two.label',
                'required' => true,
                'attr' => array(
                    'class' =>'form-control',
                    'placeholder'=>'4GB GDDR5',
                ),
                'constraints'=>array(
                    new NotBlank(),
                ),
            ))
            ->add('three',TextType::class,array(
                'label' => 'matejer_genspecs.GraphicCard.three.label',
                'required' => true,
                'attr' => array(
                    'class' =>'form-control',
                    'placeholder'=>'512-bit',
                ),
                'constraints'=>array(
                    new NotBlank(),
                ),
            ))
            ->add('four',TextType::class,array(
                'label' => 'matejer_genspecs.GraphicCard.four.label',
                'required' => true,
                'attr' => array(
                    'class' =>'form-control',
                    'placeholder'=>'512 GB/s',
                ),
                'constraints'=>array(
                    new NotBlank(),
                ),
            ))
            ->add('five',  IntegerType::class,array(
                'label' => 'matejer_genspecs.GraphicCard.five.label',
                'required' => true,
                'scale'=>0,
                'attr' => array(
                    'data-render' => 'addon',
                    'placeholder'=>'1250',
                    'class' =>'form-control',
                    'min' =>'100',
                    'max' =>'10000',
                    'aria-describedby' => 'addon-five',
                    'data-addon'=>  'matejer_genspecs.GraphicCard.five.unit',
                ),
                'constraints'=> array(
                    new GreaterThanOrEqual(array('value' => 100)),
                    new LessThanOrEqual(array('value' => 10000)),
                ),
            ))
            ->add('six',  IntegerType::class,array(
                'label' => 'matejer_genspecs.GraphicCard.six.label',
                'required' => true,
                'scale'=>0,
                'attr' => array(
                    'data-render' => 'addon',
                    'class' =>'form-control',
                    'placeholder'=>'95',
                    'min' =>'1',
                    'max' =>'250',
                    'aria-describedby' => 'addon-six',
                    'data-addon'=>  'matejer_genspecs.GraphicCard.six.unit',
                ),
                'constraints'=> array(
                    new GreaterThanOrEqual(array('value' => 1)),
                    new LessThanOrEqual(array('value' => 250)),
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
            'csrf_token_id' => 'graphic_card',
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
