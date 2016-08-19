<?php

namespace ABO\UserBundle\Form;

use ABO\MainBundle\Form\Phone\PhoneUserType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserPhoneType extends AbstractType {
    
    
    private $phones;
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $this->phones = $options['phones'];

        $phones = $this->phones;
        $set_phones = function(FormInterface $form) use ($phones){
            
            $phoneNames = ['phoneOne', 'phoneTwo', 'phoneThree'];
            for($i = 0; $i<3; $i++){
                if( isset($phones[$i]) ){
                    $form->add($phoneNames[$i], PhoneUserType::class, array(
                        'phone' => $phones[$i],
                        'number' => $i,
                    ));
                }
                else{
                    $form->add($phoneNames[$i], PhoneUserType::class, array(
                        'number' => $i,
                    ));
                }
            }
        };
        
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($set_phones) {
                $set_phones($event->getForm());
            }
        );
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'cascade_validation' => false,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'user_phone',
            'phones' => array(),
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'abo_userbundle_user';
    }
}
