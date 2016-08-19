<?php

namespace ABO\ShopBundle\Form;

use ABO\MainBundle\Form\AddressShopType;
use ABO\MainBundle\Form\Email\EmailShopType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class ShopType extends AbstractType {
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('name',TextType::class,array(
                'required' => true,
                'attr' => array(
                    'class'=>'form-control',
                    'placeholder' => 'matejer_shop.name_placeholder',
                )
            ))
            ->add('slogan',TextType::class,array(
                'required' => true,
                'attr' => array(
                    'class'=>'form-control',
                    'placeholder' => 'matejer_shop.slogan_placeholder',
                )
            ))
            ->add('email', EmailShopType::class,array(
                'mapped'=>false,
            ))
            ->add('address', AddressShopType::class, array(
                'required' => true,
                'constraints' => new Valid(),
            ))
        ;
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ABO\ShopBundle\Entity\Shop',
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
        return 'abo_shopbundle_shop';
    }
}
