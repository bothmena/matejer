<?php

namespace ABO\MainBundle\Form\Phone;

use ABO\MainBundle\Entity\PhoneUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class PhoneUserType extends AbstractType {
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    private $phone;
    private $number;
    
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $this->phone = $options['phone'];
        $this->number = $options['number'];

        $builder
//            ->add('phoneCode')
//            ->add('subscriber')
//            ->add('user')
            ->add('subscriber', TextType::class, array(
                'data' => is_null($this->phone)? '':$this->phone->getSubscriber(),
                'label' => $this->number === 0? 'matejer_phone.user_phones' : ' ',
                'attr' => array(
                    'class'=>'form-control .input-mask',
                    "data-inputmask" => "'mask': '99 999 999'",
                    'data-mask' => true,
                ),
                'constraints'=>array(
                    new Regex(array(
                        'pattern' => '/^\d{2} {1}\d{3} {1}\d{3}$/',
                    ))
                )
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {

        $resolver->setDefaults(array(
            'data_class' => 'ABO\MainBundle\Entity\PhoneUser',
            'cascade_validation' => true,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'phone_user',
            'phone'=>null,
            'number'=>0,
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'abo_mainbundle_phoneuser';
    }
}
