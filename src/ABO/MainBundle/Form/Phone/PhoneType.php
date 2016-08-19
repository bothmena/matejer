<?php

namespace ABO\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\Regex;

class PhoneType extends AbstractType
{
    private $subscriber;
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $this->subscriber = $options['subscriber'];

        $builder
            ->add('phoneCode',HiddenType::class,array(
                'required'    => true,
                'attr' => array(
                    'class' => 'form-control',
                    'readonly'=>'true',
                ),
                //'data'=> $this->phoneCode == null ? '+216' : $this->phoneCode,
                'data'=> '+216',
                'read_only' => true,
                'constraints' => array(
                    new EqualTo(array('value' => '+216')),
                ),
            ))
            ->add('subscriber',TextType::class,array(
                'required'    => true,
                'attr' => array(
                    'class' => 'form-control __phone_type',
                    'data-regex' => '/^[0-9]{2} {1}[0-9]{3} {1}[0-9]{3}$/',
                    'data-format' => 'XX XXX XXX',
                    'aria-describedby'=>"code-addon",
                ),
                'data'=> $this->subscriber === null ? '' : $this->subscriber,
                'constraints' => array(
                    new Regex(array(
                        'pattern' => '/^[0-9]{2} {1}[0-9]{3} {1}[0-9]{3}$/',
                    )),
                ),
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {

        $resolver->setDefaults(array(
            'data_class' => 'ABO\MainBundle\Entity\Phone',
            'cascade_validation' => true,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'phone',
            'subscriber'=>null,
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'abo_mainbundle_phone';
    }
}
