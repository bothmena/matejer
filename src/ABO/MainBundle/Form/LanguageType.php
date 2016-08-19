<?php

namespace ABO\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LanguageType extends AbstractType {

    private $locale;

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $this->locale = $options['locale'];

        $builder
            ->add('language', ChoiceType::class, array(
                'required' => true,
                'label' => '',
                'data' => $this->locale,
                'placeholder'=>'matejer_language.language',
                'choices'=> array(
                    //'matejer_language.ar' => 'ar',
                    'matejer_language.en' => 'en',
                    'matejer_language.fr' => 'fr',
                ),
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {

        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'locale' => 'fr',
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix() {

        return 'abo_mainbundle_main_search';
    }
}
