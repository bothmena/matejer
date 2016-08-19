<?php

namespace ABO\MainBundle\Form\Specification;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class FicheProductType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('group',TextType::class,array(
                'required'    => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
                'constraints'=>array(
                    new Length(array(
                        'min'        => 2,
                        'max'        => 60,
                        'minMessage' => 'fiche_product.group.length_min',
                        'maxMessage' => 'fiche_product.group.length_max',
                    )),
                ),
            ))
            ->add('name',TextType::class,array(
                'required'    => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
                'empty_data' => '',
                'constraints'=>array(
                    new Length(array(
                        'min'        => 0,
                        'max'        => 60,
                        'minMessage' => 'fiche_product.name.length_min',
                        'maxMessage' => 'fiche_product.name.length_max',
                    )),
                ),
            ))
            ->add('value',TextType::class,array(
                'required'    => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
                'constraints'=>array(
                    new Length(array(
                        'min'        => 1,
                        'max'        => 2000,
                        'minMessage' => 'fiche_product.value.length_min',
                        'maxMessage' => 'fiche_product.value.length_max',
                    )),
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
            'data_class' => 'ABO\MainBundle\Entity\FicheProduct',
            'cascade_validation' => true,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'fiche_product',
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
