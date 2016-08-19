<?php

namespace ABO\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints\Email;

class NewEmailType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('current_email',EmailType::class,array(
                'required' => true,
                'label' => 'main_email_change_email.current',
                'mapped' => false,
                'constraints' => new Email(),
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('new_email',EmailType::class,array(
                'required' => true,
                'label' => 'main_email_change_email.new',
                'mapped' => false,
                'constraints' => new Email(array(
                    'message' => 'user.email.email',
                    'checkMX' => true,
                )),
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('current_password', PasswordType::class, array(
                'required' => true,
                'label' => 'main_email_change_email.password',
                'mapped' => false,
                'constraints' => new UserPassword(),
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ABO\UserBundle\Entity\User',
            'cascade_validation' => true,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'new_email',
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'abo_userbundle_new_email';
    }
}
