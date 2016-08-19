<?php

namespace ABO\UserBundle\Form;

use ABO\MainBundle\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfirmedFormType extends AbstractType {
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',TextType::class,array(
                'required' => false,
                'label' => '',
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'user_registration_confirmed.username_ph'
                ),
                'data'=>'',
                'translation_domain'=>'messages',
            ))
            ->add('image', ImageType::class, array(
                'mapped'=>false,
                'required' => false,
                'label'=>'matejer_image.image_label',
                'translation_domain'=>'messages',
                'iLabel'=>'matejer_image.image_label',
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
            'csrf_token_id' => 'confirmed_form',
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'abo_confirmed_form';
    }
}
