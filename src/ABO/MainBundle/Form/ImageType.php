<?php

namespace ABO\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageType extends AbstractType {
    
    private $iLabel;
    private $required;
    private $wellId;

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $this->required = $options['required'];
        $this->iLabel = $options['iLabel'];
        $this->wellId = $options['wellId'];

        $builder
            ->add('file',FileType::class,array(
                'required' => $this->required,
                'label'=>  $this->iLabel,
                'attr' => array(
                    'well' => $this->wellId,
                    'accept'=>'image/jpeg,image/png',
                )
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {

        $resolver->setDefaults(array(
            'data_class' => 'ABO\MainBundle\Entity\Image',
            'cascade_validation' => true,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'image',
            'required' => true,
            'iLabel' => 'matejer_image.image_label',
            'wellId' => 'list',
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix() {
        
        return 'abo_mainbundle_image';
    }
}
