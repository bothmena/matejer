<?php

namespace ABO\MainBundle\Form\Product;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder
            ->add('reference',TextType::class,array(
                'label'=>'matejer_product.reference',
                'translation_domain' => 'messages',
                'required' => FALSE,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('name',TextType::class,array(
                'label'=>'matejer_product.name',
                'translation_domain' => 'messages',
                'required' => FALSE,
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'matejer_product.name_placeholder'
                ),
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ABO\MainBundle\Entity\Product',
            'cascade_validation' => true,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'product',
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'abo_mainbundle_product';
    }
}
