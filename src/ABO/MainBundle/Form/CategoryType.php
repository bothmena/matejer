<?php

namespace ABO\MainBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType {
    
    private $categories;
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $this->categories = $options['categories'];

        $categories = $this->categories;
        $fillForm = function(FormInterface $form) use ($categories){
            foreach ($categories as $parent => $cats) {
                $name = str_replace("-", "_", $parent);
                    $form ->add($name, EntityType::class,array(
                    'class'=>'ABO\MainBundle\Entity\Category',
                    'choices' => $cats,
                    'choice_label' => 'translatable',
                    'translation_domain'=> 'messages',
                    'label' => 'matejer_category.'.$parent,
                    'required'    => false,
                    'multiple' => true,
                    'expanded' => true,
                ));
            }
        };
        
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($fillForm) {
                $fillForm($event->getForm());
            }
        );
        
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {

        $resolver->setDefaults(array(
            'cascade_validation' => true,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'category',
            'categories' => array(),
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'abo_mainbundle_category';
    }
}
