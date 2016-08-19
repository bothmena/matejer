<?php

namespace ABO\MainBundle\Form\Specification;

use ABO\MainBundle\Entity\Feature;
use ABO\MainBundle\Services\ABOFileLoader;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductFeaturesType extends AbstractType {

    private     $category;
    private     $trademark;
    private     $loader;


    public function __construct( ABOFileLoader $loader ) {

        $this->loader = $loader;
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $this->category = $options['category'];
        $this->trademark = $options['trademark'];
        
        $builder
            ->add('feature', EntityType::class, array(
                'class' => 'ABOMainBundle:Feature',
                'label' => 'matejer_product.feature',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('f')
                        ->where('f.category = :category')
                        ->andWhere('f.trademark = :trademark')
                        ->setParameters(array('category'=>  $this->category,'trademark' => $this->trademark))
                        ->orderBy('f.name');
                },
                'choice_attr' => function(Feature $feature) {
                    return array(//
                        'data-img-label' => $feature->getName(),
                        'data-img-src' => $this->loader->getImage($feature->getImage()->getSource() ,'mini_cover', $feature->getImage()->getGcs()),
                    );
                },
                'choice_label' => 'name',
                'multiple'=>true,
                'required'    => false,
                'choice_translation_domain' => 'messages',
                'empty_data' => array(),
                'attr' => array(
                    'class'=>'image-picker',
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
            'csrf_token_id' => 'features',
            'category' => null,
            'trademark' => null,
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'abo_features';
    }
}
