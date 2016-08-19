<?php

namespace ABO\MainBundle\Form\Phone;

use ABO\MainBundle\Entity\PhoneShop;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PhoneShopType extends AbstractType {
    
    private $phone;
    private $number;
    
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $this->phone = $options['phone'];
        $this->number = $options['number'];

        $builder
            ->add('subscriber', TextType::class, array(
                'data' => is_null($this->phone)? '':$this->phone->getSubscriber(),
                'label' => $this->number == 0? 'matejer_phone.shop_phones' : ' ',
                'attr' => array(
                    'class'=>'form-control .input-mask',
                    "data-inputmask" => "'mask': '99 999 999'",
                    'data-mask' => true,
                ),
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {

        $resolver->setDefaults(array(
            'data_class' => 'ABO\MainBundle\Entity\PhoneShop',
            'validation_groups'=>false,
            'cascade_validation' => true,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'phone_shop',
            'number'=>0,
            'phone'=>null,
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'abo_mainbundle_phoneshop';
    }
}
