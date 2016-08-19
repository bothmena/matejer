<?php

namespace ABO\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType as Password;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class PasswordType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', Password::class, array(
                'required' => true,
                'label' => 'remove_password_modal.password',
                'mapped' => false,
                'constraints' => new UserPassword(),
                'attr' => array(
                    'class' => 'form-control',
                    'ng-keydown'=>'disableSubmit($event)',
                ),
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {

        $resolver->setDefaults(array(
            'data_class' => 'ABO\UserBundle\Entity\User',
            'cascade_validation' => true,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'password',
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'abo_mainbundle_password';
    }
}
