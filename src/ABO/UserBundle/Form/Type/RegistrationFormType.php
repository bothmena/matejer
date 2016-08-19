<?php

namespace ABO\UserBundle\Form\Type;

use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class RegistrationFormType extends BaseType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        parent::buildForm($builder, $options);

        $builder
            ->remove('username')
            ->add('email', EmailType::class, array(
                'required'=>true,
                'label' => 'matejer_email.email', 
                'attr'=>array(
                    'placeholder' => 'matejer_email.email',
                    'class'=>'form-control'
                )
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array(
                    'label' => 'user_security_register.pass',
                    'attr'=>array(
                        'placeholder' => 'user_security_register.pass',
                        'class'=>'form-control'
                    )
                ),
                'second_options' => array(
                    'label' => 'user_security_register.repass',
                    'attr'=>array(
                        'placeholder' => 'user_security_register.repass',
                        'class'=>'form-control'
                    )
                ),
                'invalid_message' => 'user.password.mismatch',
            ))
            ->add('lastname', TextType::class,array(
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'matejer_user.lastname',
                ),
            ))
            ->add('firstname', TextType::class,array(
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'matejer_user.firstname',
                ),
            ))
            ->add('gender', ChoiceType::class,array(
                'choices' => array(
                    'matejer_main.gender_male'=>'male',
                    'matejer_main.gender_female'=>'female',
                ),
                'choice_translation_domain' => 'messages',
                'required'=>true,
                'expanded' => false,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('birthday', BirthdayType::class,array(
                'required'=> true,
                'years' => range(date('Y') -12, date('Y') -120),
                'format'      => 'dd MMMM yyyy',
            ))
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver) {

        $resolver->setDefaults(array(
            'data_class' => 'ABO\UserBundle\Entity\User',
            'cascade_validation' => true,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'registration_form',
        ));
    }
    
    public function getParent() {

        return BaseType::class;
    }

    public function getBlockPrefix() {

        return 'abo_user_registration';
    }
}
