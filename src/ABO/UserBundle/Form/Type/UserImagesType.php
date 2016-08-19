<?php

namespace ABO\UserBundle\Form\Type;

use ABO\MainBundle\Entity\ImageUser;
use ABO\MainBundle\Form\ImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserImagesType extends AbstractType {

    private $logos;
    private $loader;

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $this->logos = $options['logos'];
        $this->loader = $options['loader'];

        $builder
            ->add('logo', ImageType::class, array(
                'label'=>'matejer_user.image_lbl',
                'iLabel' => 'matejer_image.image_label',
                'required' => false,
            ))
            ->add('logos', EntityType::class,array(
                'class'=>'ABOMainBundle:ImageUser',
                'label'=>'matejer_user.old_image',
                'choices' => $this->logos,
                'choice_label' => function (ImageUser $image) {
                    return $image->getImage()->getImage();
                },
                'required'    => false,
                'choice_attr' => function(ImageUser $image) {
                    return array(
                        'data-img-label'=>$image->getImage()->getImage(),
                        'data-img-src'=>$this->loader->getImage($image->getImage()->getSource(), 'avatar', $image->getImage()->getGcs()),
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
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'cascade_validation' => true,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'user_images',
            'logos' => array(),
            'loader' => null,
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'abo_shopbundle_userimages';
    }
}
