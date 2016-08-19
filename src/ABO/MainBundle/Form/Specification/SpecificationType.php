<?php

namespace ABO\MainBundle\Form\Specification;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Valid;

class SpecificationType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder
            ->add('ficheProduct', CollectionType::class, array(
                'entry_type'   => FicheProductType::class,
                'label' => '',
                'mapped' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'constraints' => new Valid(),
            ))
            ->add('language', ChoiceType::class, array(
                'mapped' => false,
                'label' => 'matejer_language.language',
                'choices'=>array(
                    'matejer_language.en'=>'en',
                    'matejer_language.fr'=>'fr',
                    'matejer_language.ar'=>'ar',
                ),
                'attr' => array(
                    'class' => 'form-control',
                    'ng-model' => 'abo_mainbundle_specification.language',
                    'ng-change' => 'changeDir()'
                ),
                'constraints' => new Choice(['choices' => array('en', 'fr', 'ar'),'message' => 'fiche_product.language.choice']),
            ));
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'cascade_validation' => true,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'specification',
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'abo_mainbundle_specification';
    }
}
