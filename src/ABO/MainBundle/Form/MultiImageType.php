<?php

namespace ABO\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MultiImageType extends AbstractType {

    private $isRequired;
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $this->isRequired = $options['isRequired'];

        $builder
            ->add('file',FileType::class,array(
                'required' => $this->isRequired,
                'label' => 'matejer_product.file',
                'mapped'=>false,
                'translation_domain' => 'messages',
        		//'data_class' => null,
                'attr' => array(
                    'well' => 'multi-file',
                    'accept'=>'image/jpeg,image/png',
                )
            ))
            ->add('files',FileType::class,array(
                'required' => false,
                'multiple' => true,
                'mapped'=>false,
                'label' => 'matejer_product.files',
                'translation_domain' => 'messages',
        		//'data_class' => null,
                'attr' => array(
                    'well' => 'multi-files',
                    'accept'=>'image/jpeg,image/png',
                )
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ABO\MainBundle\Entity\Image',
            'cascade_validation' => true,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'multi_image',
            'isRequired'=>true,
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix() {
        
        return 'abo_mainbundle_image';
    }
}
