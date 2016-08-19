<?php

namespace ABO\MainBundle\Form\Specification;

use ABO\MainBundle\Form\ImageType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeatureType extends AbstractType {

    private $categories;
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $this->categories = $options['categories'];

        $builder
            ->add('name',TextType::class,array(
                'required'    => true,
                'label' => 'matejer_feature.name.en',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('description',TextareaType::class,array(
                'required'    => true,
                'label' => 'matejer_feature.description.en',
                'attr' => array(
                    //'class' => 'ckeditor',
                    'style' => 'resize: none;width: 100%; height: 250px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;'
                ),
            ))
            ->add('nameFr',TextType::class,array(
                'required'    => false,
                'mapped' => false,
                'label' => 'matejer_feature.name.fr',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('descriptionFr',TextareaType::class,array(
                'required'    => false,
                'mapped' => false,
                'label' => 'matejer_feature.description.fr',
                'attr' => array(
                    //'class' => 'ckeditor',
                    'style' => 'resize: none;width: 100%; height: 250px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;'
                ),
            ))
            ->add('nameAr',TextType::class,array(
                'required'    => false,
                'mapped' => false,
                'label' => 'matejer_feature.name.ar',
                'attr' => array(
                    'class' => 'form-control',
                    'dir' => 'rtl',
                ),
            ))
            ->add('descriptionAr',TextareaType::class,array(
                'required'    => false,
                'mapped' => false,
                'label' => 'matejer_feature.description.ar',
                'attr' => array(
                    //'class' => 'ckeditor',
                    'dir' => 'rtl',
                    'style' => 'resize: none;width: 100%; height: 250px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;'
                ),
            ))
            ->add('category', EntityType::class, array(
                'class' => 'ABOMainBundle:Category',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where('c.id IN (:ids)')
                        ->setParameter('ids', $this->categories)
                        ->orderBy('c.parent');
                },
                'choice_label' => 'translatable',
                'group_by' => 'transParent',
                'choice_translation_domain' => 'messages',
                'placeholder' => 'Choose Category',
                'required'    => true,
                'label' => 'matejer_category.category',
                'attr' => array(
                    'class' => 'form-control',
                    'style'=>"width: 100%;"
                ),
            ))
            ->add('image', ImageType::class, array(
                'mapped'=>false,
                'required' => false,
                'iLabel' => 'matejer_feature.image',
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {

        $resolver->setDefaults(array(
            'data_class' => 'ABO\MainBundle\Entity\Feature',
            'cascade_validation' => true,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'feature',
            'categories' => array(),
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'abo_mainbundle_feature';
    }
}
