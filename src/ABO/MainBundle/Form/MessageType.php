<?php

namespace ABO\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class MessageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder
            ->add('message', TextareaType::class, array(
                'attr'=>array(
                    'class'=>'form-control',
                    'style'=>'resize: none',
                    'rows'=>10
                ),
                'constraints' => array(
                    new Length(array('min'=>10, 'max'=>1000)),
                    new NotBlank(),
                ),
            ))
            ->add('subject', TextType::class, array(
                'mapped'=>false,
                'required' => false,
                'attr'=>array(
                    'class'=>'form-control',
                ),
                'constraints' => array(
                    new Length(array('max'=>100)),
                )
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ABO\MainBundle\Entity\Message',
            'cascade_validation' => true,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'message',
        ));
    }
}
