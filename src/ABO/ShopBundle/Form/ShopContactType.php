<?php

namespace ABO\ShopBundle\Form;

use ABO\MainBundle\Form\Email\EmailShopType;
use ABO\MainBundle\Form\Phone\PhoneShopType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ShopContactType extends AbstractType {
    
    private $phones;
    private $emails;
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $this->phones = $options['phones'];
        $this->emails = $options['emails'];
        
        $phones = $this->phones;
        $emails = $this->emails;
        
        $email_phone = function(FormInterface $form) use ($phones, $emails){
            
            $phoneNames = ['phoneOne', 'phoneTwo', 'phoneThree'];
            $emailNames = ['emailOne', 'emailTwo', 'emailThree'];
            
            for($i = 0;$i<3;$i++){
                if( isset($emails[$i]) ){
                    $form->add($emailNames[$i], EmailShopType::class, array(
                        'mapped'=>false,
                        'number' => $i,
                        'email' => $emails[$i],
                    ));
                }
                else{
                    $form->add($emailNames[$i], EmailShopType::class, array(
                        'mapped'=>false,
                        'number' => $i,
                    ));
                }
            }
            for($i = 0;$i<3;$i++){
                if( isset($phones[$i]) ){
                    $form->add($phoneNames[$i], PhoneShopType::class, array(
                        'mapped'=>false,
                        'number' => $i,
                        'phone' => $phones[$i],
                    ));
                }
                else{
                    $form->add($phoneNames[$i], PhoneShopType::class, array(
                        'mapped'=>false,
                        'number' => $i,
                    ));
                }
            }
            $form->add('website', UrlType::class,array(
                'required' => false,
                'label' => 'matejer_shop.website',
                'attr' => array(
                    'class'=>'form-control',
                )
            ));
        };
        
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($email_phone) {
                $email_phone($event->getForm());
            }
        );
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        
        $resolver->setDefaults(array(
            'data_class' => 'ABO\ShopBundle\Entity\Shop',
            'cascade_validation' => true,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'shop_contact',
            'phones' => array(),
            'emails' => array(),
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'abo_shopbundle_shop_contact';
    }
}
