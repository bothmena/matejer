<?php

namespace ABO\ShopBundle\Form;

use ABO\ShopBundle\Entity\Shop;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CollectionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    
    private $categoriesId;
    private $shop;
    
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $this->categoriesId = $options['categoriesId'];
        $this->shop = $options['shop'];

        $builder
            ->add('name', TextType::class, array(
                'required'    => true,
                'label' => 'matejer_main.name',
                'attr' => array(
                    'class' => 'form-control'
                ),
            ))
            ->add('parent', EntityType::class, array(
                'class' => 'ABOShopBundle:Collection',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where('c.shop = :shop')
                        ->andWhere('c.anyParent = :anyParent')
                        ->setParameters(array('shop'=> $this->shop, 'anyParent'=> true))
                        ->orderBy('c.name', 'ASC');
                },
                'choice_label' => 'name',
                'placeholder' => 'matejer_collection.parent.ph',
                'label' => 'matejer_collection.parent.label',
                'required'    => false,
                'attr' => array(
                    'class' => 'form-control',
                    'style' => 'width: 100%;'
                ),
            ))
            ->add('category', EntityType::class, array(
                'class' => 'ABOMainBundle:Category',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where('c.id IN (:ids)')
                        ->setParameter('ids', $this->categoriesId)
                        ->orderBy('c.name', 'ASC');
                },
                'choice_label' => 'translatable',
                'group_by' => 'transParent',
                'choice_translation_domain' => 'messages',
                'placeholder' => 'matejer_category.category',
                'label' => 'matejer_collection.select_category',
                'translation_domain' => 'messages',
                'required'    => false,
                'attr' => array(
                    'class' => 'form-control',
                    'style'=>'width: 100%;'
                ),
            ))
            ->add('anyParent',CheckboxType::class,array(
                'required'    => false,
                'label'       => 'matejer_collection.anyParent.label'
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ABO\ShopBundle\Entity\Collection',
            'cascade_validation' => true,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'collection',
            'categoriesId' => array(),
            'shop' => null,
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'abo_shopbundle_collection';
    }
}
