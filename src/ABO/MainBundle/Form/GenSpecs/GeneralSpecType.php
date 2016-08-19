<?php

namespace ABO\MainBundle\Form\GenSpecs;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Url;

class GeneralSpecType extends AbstractType {
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description',TextareaType::class,array(
                'label' => 'matejer_genspecs.description',
                'required' => $options['required'],
                'attr' => array(
                    'rows'=>'5',
                    'class'=>'form-control',
                    'style'=>'resize: none;'
                ),
                'translation_domain'=>'messages',
                'constraints' => $options['constraints'],
            ))
            ->add('source',UrlType::class,array(
                'required' => false,
                'label' => 'matejer_genspecs.source',
                'attr' => array(
                    'class' => 'form-control',
                ),
                'translation_domain'=>'messages',
                'constraints'=>new Url(array(
                    'checkDNS'=>true,
                    'message'=>"",
                    'protocols'=>["http", "https"]
                )),
            ))
            ->add('videoSite',ChoiceType::class,array(
                'label' => 'matejer_genspecs.video.site',
                'choices'=>array(
                    'matejer_genspecs.video.youtube'=>'youtube',
                    'matejer_genspecs.video.vimeo'=>'vimeo',
                    'matejer_genspecs.video.dailymotion'=>'dailymotion',
                ),
                'choice_translation_domain'=>'messages',
                'translation_domain'=>'messages',
                'required' => false,
                'attr' => array('class'=>'form-control'),
            ))
            ->add('video',TextType::class,array(
                'label' => 'matejer_genspecs.video.video',
                'required'    => false,
                'attr' => array(
                    'class' => 'form-control',
                ),
                'translation_domain'=>'messages',
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {

        $resolver->setDefaults(array(
            'data_class' => 'ABO\MainBundle\Entity\GeneralSpec',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'general_spec',
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'abo_mainbundle_general_specs';
    }
}
