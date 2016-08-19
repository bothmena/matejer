<?php

namespace ABO\ShopBundle\Form;

use ABO\MainBundle\Entity\ImageShop;
use ABO\MainBundle\Form\ImageType;
use ABO\MainBundle\Services\ABOFileLoader;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShopImagesType extends AbstractType {

    private $logos;
    private $covers;
    private $loader;
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $this->logos = $options['logos'];
        $this->covers = $options['covers'];
        $this->loader = $options['loader'];

        $builder
            ->add('logo', ImageType::class, array(
                'label'=>'modal_shop_images.new_logo',
                'required' => false,
                'iLabel' => 'modal_shop_images.new_logo',
                'wellId' => 'logo-preview',
            ))
            ->add('cover', ImageType::class, array(
                'label'=>'modal_shop_images.new_cover',
                'required' => false,
                'iLabel' => 'modal_shop_images.new_cover',
                'wellId' => 'cover-preview',
            ))
            ->add('logos', EntityType::class, array(
                'class'=>'ABOMainBundle:ImageShop',
                'label'=>'modal_shop_images.old_logo',
                'choices' => $this->logos,
                'choice_label' => function (ImageShop $image) {
                    return $image->getImage()->getImage();
                },
                'required'    => false,
                'choice_attr' => function(ImageShop $image) {
                    return array(
                        'data-img-label'=>$image->getImage()->getImage(),
                        'data-img-src'=>$this->loader->getImage($image->getImage()->getSource(), 'avatar', $image->getImage()->getGcs()),
                    );
                },
                'attr'=>array('class'=>'form-control image-picker'),
            ))
            ->add('covers', EntityType::class, array(
                'class'=>'ABOMainBundle:ImageShop',
                'label'=>'modal_shop_images.old_cover',
                'choices' => $this->covers,
                'choice_label' => function (ImageShop $image) {
                    return $image->getImage()->getImage();
                },
                'required'    => false,
                'choice_attr' => function(ImageShop $image) {
                    return array(
                        'data-img-label'=>$image->getImage()->getImage(),
                        'data-img-src'=>$this->loader->getImage($image->getImage()->getSource(), 'mini_cover', $image->getImage()->getGcs()),
                    );
                },
                'attr'=>array('class'=>'form-control image-picker'),
            ))
        ;
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver) {

        $resolver->setDefaults(array(
            'cascade_validation' => true,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'shop_images',
            'logos' => array(),
            'covers' => array(),
            'loader' => null,
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'abo_shopbundle_shopimages';
    }
}
