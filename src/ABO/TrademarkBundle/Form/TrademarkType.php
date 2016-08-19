<?php

namespace ABO\TrademarkBundle\Form;

use ABO\MainBundle\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrademarkType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,array(
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('slogan',TextType::class,array(
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('description',TextareaType::class,array(
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                    'style' => 'resize: none',
                    'rows' => 5,
                ),
            ))
            ->add('image', ImageType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ABO\TrademarkBundle\Entity\Trademark',
            'cascade_validation' => true,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'trademark',
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'abo_trademarkbundle_trademark';
    }
}
