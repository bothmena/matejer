<?php

namespace ABO\UserBundle\Form;

use ABO\UserBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserPersonalType extends AbstractType {

    /**
     * @var User $user
     */
    private $user;

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $this->user = $options['user'];

        $builder
            ->add('firstname',TextType::class,array(
                'required'=> false,
                'label' => 'matejer_user.firstname',
                'translation_domain' => 'messages',
                'attr'=>array(
                    'maxlength' => '30',
                    'class' => 'form-control',
                )
            ))
            ->add('lastname',TextType::class,array(
                'required'=> false,
                'label' => 'matejer_user.lastname',
                'translation_domain' => 'messages',
                'attr'=>array(
                    'maxlength' => '30',
                    'class' => 'form-control',
                )
            ))
            ->add('username',TextType::class,array(
                'required'=> false,
                'label' => 'matejer_user.username',
                'translation_domain' => 'messages',
                'data' => $this->user->getUsername() === $this->user->getEmail() ? '' : $this->user->getUsername(),
                'attr'=>array(
                    'maxlength' => '30',
                    'class' => 'form-control',
                )
            ))
            ->add('birthday',BirthdayType::class,array(
                'required'=> false,
                'label' => 'matejer_user.birthday',
                'translation_domain' => 'messages',
                'years' => range(date('Y') -12, date('Y') -120),
                'format'      => 'dd MMMM yyyy',
            ))
            ->add('gender',ChoiceType::class,array(
                'required'=> false,
                'choices' => array(
                    'matejer_main.gender_male'=>'male',
                    'matejer_main.gender_female'=>'female',
                ),
                'attr'=>array(
                    'class' => 'form-control',
                ),
                'choice_translation_domain' => 'messages',
                'label' => 'matejer_user.gender',
                'translation_domain' => 'messages',
            ))
            ->add('language',ChoiceType::class,array(
                'required'=> false,
                'choices' => array(
                    //'matejer_language.ar'=>'ar',
                    'matejer_language.fr'=>'fr',
                    'matejer_language.en'=>'en',
                ),
                'attr'=>array(
                    'class' => 'form-control',
                ),
                'choice_translation_domain' => 'messages',
                'label' => 'matejer_language.language',
                'translation_domain' => 'messages',
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
            'csrf_token_id' => 'user_personal',
            'user' => null,
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'abo_userbundle_user_personal';
    }
}
