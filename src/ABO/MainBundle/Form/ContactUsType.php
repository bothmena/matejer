<?php

namespace ABO\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;

class ContactUsType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('email', EmailType::class, array(
                'required' => true,
                'label' => '',
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'contact_us.email.ph',
                ),
                'constraints' => array (
                    new Email(array('checkHost' => true, 'checkMX' => true)),
                )
            ))
            ->add('name', TextType::class, array(
                'required' => true,
                'label' => '',
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'contact_us.name.ph',
                ),
                'constraints' => array(
                    new Length(array('min'=>3)),
                )
            ))
            ->add('subject', TextType::class, array(
                'required' => true,
                'label' => '',
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'contact_us.subject.ph',
                ),
                'constraints' => array(
                    new Length(array('max'=>100, 'min'=>5)),
                )
            ))
            ->add('message', TextareaType::class, array(
                'required' => true,
                'label' => '',
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'contact_us.message.ph',
                ),
                'constraints' => array(
                    new Length(array('max'=>1000, 'min'=>25)),
                )
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {

        $resolver->setDefaults(array(
            'csrf_protection' => true,
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix() {

        return 'abo_mainbundle_contactus';
    }
}
