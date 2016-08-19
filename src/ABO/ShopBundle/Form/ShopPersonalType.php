<?php

namespace ABO\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShopPersonalType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,array(
                'required' => true,
                'attr' => array(
                    'class'=>'form-control',
                )
            ))
            ->add('slogan',TextType::class,array(
                'required' => true,
                'attr' => array(
                    'class'=>'form-control',
                )
            ))
            ->add('currency',ChoiceType::class,array(
                'required' => true,
                'attr' => array(
                    'class'=>'form-control',
                ),
                'choices' => array(
                    'matejer_ex_currency.eur' => 'eur',
                    'matejer_ex_currency.tnd' => 'tnd',
                    'matejer_ex_currency.usd' => 'usd',
                ),
            ))
            ->add('description',TextareaType::class,array(
                'required' => true,
                'attr' => array(
                    'class'=>'form-control',
                    'rows' => '5',
                    'style' => 'resize: none;'
                )
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ABO\ShopBundle\Entity\Shop',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'shop_personal',
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'abo_shopbundle_shop_personal';
    }
}
