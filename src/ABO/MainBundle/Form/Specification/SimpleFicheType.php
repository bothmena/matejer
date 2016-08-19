<?php

namespace ABO\MainBundle\Form\Specification;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class SimpleFicheType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('group',TextType::class,array(
                'required'    => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
                'constraints'=>array(
                    new NotBlank(),
                    new Length(array(
                        'min'        => 2,
                        'max'        => 60,
                        'minMessage' => 'Group name must be at least {{ limit }} characters long',
                        'maxMessage' => 'Group name cannot be longer than {{ limit }} characters',
                    )),
                ),
            ))
            ->add('value',TextType::class,array(
                'required'    => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
                'constraints'=>array(
                    new NotBlank(),
                ),
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {

        $resolver->setDefaults(array(
            'data_class' => 'ABO\MainBundle\Entity\FicheProduct',
            'cascade_validation' => true,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'simple_fiche',
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'abo_mainbundle_fiche';
    }
}
