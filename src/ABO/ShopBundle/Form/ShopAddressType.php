<?php

namespace ABO\ShopBundle\Form;

use ABO\MainBundle\Form\AddressShopType;
use ABO\MainBundle\Form\AddressType;
use ABO\MainBundle\Form\EventListener\AddressShopSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class ShopAddressType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
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
            'csrf_token_id' => 'shop_address',
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'abo_shopbundle_shop_address';
    }
}
