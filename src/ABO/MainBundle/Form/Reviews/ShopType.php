<?php

namespace ABO\MainBundle\Form\Reviews;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Range;

class ShopType extends AbstractType {
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('value',HiddenType::class,array(
                'required' => false,
                'label'=>'matejer_review.shop.value',
                'label_attr'=>array(
                    'style' => 'font-weight: bold;',
                ),
                'constraints' => array(
                    new Range(array(
                        'min'        => 1,
                        'max'        => 5,
                    )),
                    new NotNull(['message'=>'shop_review.value.not_null']),
                ),
            ))
            ->add('valueOne',HiddenType::class,array(
                'label'=>'matejer_review.shop.valueOne',
                'constraints' => array(
                    new Range(array(
                        'min'        => 1,
                        'max'        => 5,
                    )),
                ),
            ))
            ->add('valueTwo',HiddenType::class,array(
                'label'=>'matejer_review.shop.valueTwo',
                'required' => false,
                'constraints' => array(
                    new Range(array(
                        'min'        => 1,
                        'max'        => 5,
                    )),
                ),
            ))
            ->add('valueThree',HiddenType::class,array(
                'label'=>'matejer_review.shop.valueThree',
                'required' => false,
                'constraints' => array(
                    new Range(array(
                        'min'        => 1,
                        'max'        => 5,
                    )),
                ),
            ))
            ->add('valueFour',HiddenType::class,array(
                'label'=>'matejer_review.shop.valueFour',
                'required' => false,
                'constraints' => array(
                    new Range(array(
                        'min'        => 1,
                        'max'        => 5,
                    )),
                ),
            ))
            ->add('comment',TextareaType::class,array(
                'label' => 'matejer_review.form.comment_sh_ph', // => comment-ph // placeholder
                'attr'=>array(
                    'length'=>500,
                    'comment-max-length'=>500,
                    'comment-class'=>'form-control no-resize',
                ),
                'constraints' => array(
                    new Length(array('max'=> 500)),
                ),
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ABO\MainBundle\Entity\Rate',
            'cascade_validation' => true,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'shop',
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'abo_mainbundle_rate';
    }
}
