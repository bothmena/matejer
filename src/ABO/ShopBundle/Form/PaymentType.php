<?php

namespace ABO\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder
            ->add('name', TextType::class, array(
                'required'    => false,
                'label' => 'matejer_payment.name_lbl',
                'attr' => array(
                    'class' => 'form-control'
                ),
            ))
            ->add('addedValue', NumberType::class, array(
                'required'    => true,
                'label' => 'matejer_payment.addedValue',
                'scale'=>2,
                'attr' => array(
                    'class' => 'form-control',
                    'step' => '0.01',
                    'min'        => '0',
                    'max'        => '100',
                    'placeholder' => 'matejer_payment.addedValue_ph',
                ),
            ))
            ->add('advance', NumberType::class, array(
                'required'    => true,
                'label' => 'matejer_payment.advance',
                'scale'=>2,
                'attr' => array(
                    'class' => 'form-control',
                    'step' => '0.01',
                    'min'        => '0',
                    'max'        => '100',
                    'placeholder' => 'matejer_payment.advance_lbl',
                ),
            ))
            ->add('month', IntegerType::class, array(
                'required'    => true,
                'label' => 'matejer_payment.month',
                'attr' => array(
                    'class' => 'form-control',
                    'min'        => '1',
                    'max'        => '360',
                ),
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {

        $resolver->setDefaults(array(
            'data_class' => 'ABO\ShopBundle\Entity\Payment',
            'cascade_validation' => true,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'payment',
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'abo_shopbundle_payment';
    }
}
