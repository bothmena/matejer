<?php

namespace ABO\MainBundle\Form\Email;

use ABO\MainBundle\Entity\EmailShop;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmailShopType extends AbstractType {
    
    private $email;
    private $number;
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $this->email = $options['email'];
        $this->number = $options['number'];

        $builder
            ->add('email',EmailType::class,array(
                'required'=>false,
                'label' => $this->number === 0 ? 'matejer_email.emails' : ' ',
                'data' => empty($this->email)? '':$this->email->getEmail(),
                'attr'=>array(
                    'class'=>'form-control',
                    'placeholder' => 'matejer_email.shop_email',
                ),
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {

        $resolver->setDefaults(array(
            'data_class' => 'ABO\MainBundle\Entity\EmailShop',
            'cascade_validation' => true,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'email_shop',
            'email' => 0,
            'number' => null,
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'abo_mainbundle_emailshop';
    }
}
