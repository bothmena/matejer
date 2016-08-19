<?php

namespace ABO\MainBundle\Form\Product;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PreAddType extends AbstractType
{
    private $categories;
    private $parents;
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $this->categories = $options['categories'];
        $this->parents = $options['parents'];

        $builder
            ->add('parent', EntityType::class, array(
                'class' => 'ABOMainBundle:CategoryProduct',
                'choice_label' => 'product.reference',
                'choices' => $this->parents,
                'choice_translation_domain' => 'messages',
                'placeholder' => 'matejer_product.parent',
                'group_by' => 'category.translatable',
                'required'    => false,
                'attr' => array(
                    'class' => 'form-control'
                ),
            ))
            ->add('category', EntityType::class,array(
                'choices' => $this->categories,
                'class' => 'ABOMainBundle:Category',
                'label' => 'matejer_category.category',
                'choice_translation_domain' => 'messages',
                'placeholder' => 'matejer_category.category',
                'choice_label' => 'translatable',
                'group_by' => 'parent.translatable',
                'required'    => false,
                'attr' => array(
                    'class' => 'form-control'
                ),
            ))
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
            'csrf_token_id' => 'pre_add',
            'categories'=>array(),
            'parents'=>array(),
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'abo_mainbundle_productshop';
    }
}
