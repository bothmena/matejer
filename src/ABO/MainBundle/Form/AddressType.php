<?php

namespace ABO\MainBundle\Form;

use ABO\MainBundle\Entity\Place;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class AddressType extends AbstractType {

    private $country;
    private $state;
    private $city;
    private $options;
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('country', CountryType::class, array(
                'required' => true,
                'empty_data' => null,
                'attr' => array(
                    'class' => 'form-control',
                    'style' => 'width: 100%'
                ),
                'preferred_choices'=>array('TN'),
                'constraints' => new NotNull(),
            ))
            ->add('state', TextType::class, array(
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
                'empty_data' => '',
                'constraints'=> array(
                    new Length(array(
                        'min' => 3,
                        'max' => 40,
                        'minMessage' => 'address.state.length.min',
                        'maxMessage' => 'address.state.length.max',
                    )),
                    new NotBlank(),
                )
            ))
            ->add('city', TextType::class, array(
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
                'constraints'=> array(
                    new Length(array(
                        'min' => 3,
                        'max' => 40,
                        'minMessage' => 'address.city.length.min',
                        'maxMessage' => 'address.city.length.max',
                    )),
                    new NotBlank(),
                )
            ))
            ->add('street', TextType::class, array(
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                ),
                'constraints'=> new Length(array(
                    'min' => 10,
                    'max' => 85,
                    'minMessage' => 'address.street.length.min',
                    'maxMessage' => 'address.street.length.max',
                ))
            ))
            ->add('postalCode', TextType::class, array(
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                    'style' => 'width: 100%'
                ),
                'constraints'=> new Length(array(
                    'min' => 4,
                    'max' => 15,
                    'minMessage' => 'address.postalCode.length.min',
                    'maxMessage' => 'address.postalCode.length.max',
                ))
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {

        $resolver->setDefaults(array(
            'data_class' => 'ABO\MainBundle\Entity\Address',
            'cascade_validation' => true,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'address',
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'abo_mainbundle_address';
    }
}
