<?php

namespace ABO\MainBundle\Form\GenSpecs;

use ABO\MainBundle\Services\ABOFileLoader;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ClotheGSType extends AbstractType {

    private $loader;
    private $translator;
    private $one    = array('wsh-ccl-any','wsh-ccl-prm','wsh-ccl-gnt','wsh-ccl-hnd','wsh-ccl-not');
    private $two    = array('wsh-tmp-30c','wsh-tmp-40c','wsh-tmp-50c','wsh-tmp-60c','wsh-tmp-70c','wsh-tmp-95c');
    private $three  = array('ble-any','ble-nch','ble-not');
    private $four   = array('dry-ccl-any','dry-ccl-prm','dry-ccl-gnt','dry-ccl-ntr','dry-ccl-not','dry-ccl-lin','dry-ccl-drp','dry-ccl-flt','dry-ccl-shd');
    private $five   = array('dry-tmp-low','dry-tmp-mdm','dry-tmp-hgh','dry-tmp-not');
    private $six    = array('iro-ccl-any','iro-ccl-nst','iro-ccl-not');
    private $seven  = array('iro-tmp-low','iro-tmp-mdm','iro-tmp-hgh');
    private $eight  = array('dcl-ccl-any','dcl-ccl-not','dcl-ccl-shr','dcl-ccl-rdc','dcl-ccl-lwh','dcl-ccl-nst');
    private $nine   = array('dcl-slv-any','dcl-slv-fon','dcl-slv-ptr');

    public function __construct($translator, ABOFileLoader $loader) {

        $this->translator = $translator;
        $this->loader = $loader;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('description', TextareaType::class, array(
                'label' => 'matejer_genspecs.description',
                'required' => true,
                'attr' => array(
                    'rows'=>'5',
                    'class'=>'form-control',
                    'style'=>'resize: none;'
                ),
                'translation_domain'=>'messages',
                'constraints' => new NotBlank(),
            ))
            ->add('one', ChoiceType::class, array(
                'required' => false,
                'label' => 'matejer_genspecs.ClotheGS.one.label',
                'choices'=>$this->one,
                'attr' => array(
                    'class'=>'image-picker',
                ),
                'choice_attr' => function($val) {
                    return array(//
                        'data-img-label' => $this->translator->trans('matejer_genspecs.ClotheGS.one.' . $val . '.title'),
                        'data-img-src' => $this->loader->getImage('images/clothe-care/' . $val . '.png', 'clothegs', true),
                    );
                },
                'choices_as_values' => true,
            ))
            ->add('two', ChoiceType::class, array(
                'label' => 'matejer_genspecs.ClotheGS.two.label',
                'attr' => array(
                    'class'=>'image-picker',
                ),
                'required' => false,
                'choices'=>$this->two,
                'choice_attr' => function($val) {
                    return array(
                        'data-img-label' => $this->translator->trans('matejer_genspecs.ClotheGS.two.' . $val . '.title'),
                        'data-img-src' => $this->loader->getImage('images/clothe-care/' . $val . '.png', 'clothegs', true),
                    );
                },
                'choices_as_values' => true,
            ))
            ->add('three', ChoiceType::class, array(
                'choices'=>$this->three,
                'label' => 'matejer_genspecs.ClotheGS.three.label',
                'attr' => array(
                    'class'=>'image-picker',
                ),
                'required' => false,
                'choice_attr' => function($val) {
                    return array(
                        'data-img-label' => $this->translator->trans('matejer_genspecs.ClotheGS.three.' . $val . '.title'),
                        'data-img-src' => $this->loader->getImage('images/clothe-care/' . $val . '.png', 'clothegs', true),
                    );
                },
                'choices_as_values' => true,
            ))
            ->add('four', ChoiceType::class, array(
                'choices'=>$this->four,
                'label' => 'matejer_genspecs.ClotheGS.four.label',
                'attr' => array(
                    'class'=>'image-picker',
                ),
                'required' => false,
                'choice_attr' => function($val) {
                    return array(//
                        'data-img-label' => $this->translator->trans('matejer_genspecs.ClotheGS.four.' . $val . '.title'),
                        'data-img-src' => $this->loader->getImage('images/clothe-care/' . $val . '.png', 'clothegs', true),
                    );
                },
                'choices_as_values' => true,
            ))
            ->add('five', ChoiceType::class, array(
                'choices'=>$this->five,
                'label' => 'matejer_genspecs.ClotheGS.five.label',
                'attr' => array(
                    'class'=>'image-picker',
                ),
                'required' => false,
                'choice_attr' => function($val) {
                    return array(//
                        'data-img-label' => $this->translator->trans('matejer_genspecs.ClotheGS.five.' . $val . '.title'),
                        'data-img-src' => $this->loader->getImage('images/clothe-care/' . $val . '.png', 'clothegs', true),
                    );
                },
                'choices_as_values' => true,
            ))
            ->add('six', ChoiceType::class, array(
                'choices'=>$this->six,
                'label' => 'matejer_genspecs.ClotheGS.six.label',
                'attr' => array(
                    'class'=>'image-picker',
                ),
                'required' => false,
                'choice_attr' => function($val) {
                    return array(//
                        'data-img-label' => $this->translator->trans('matejer_genspecs.ClotheGS.six.' . $val . '.title'),
                        'data-img-src' => $this->loader->getImage('images/clothe-care/' . $val . '.png', 'clothegs', true),
                    );
                },
                'choices_as_values' => true,
            ))
            ->add('seven', ChoiceType::class, array(
                'choices'=>$this->seven,
                'label' => 'matejer_genspecs.ClotheGS.seven.label',
                'attr' => array(
                    'class'=>'image-picker',
                ),
                'required' => false,
                'choice_attr' => function($val) {
                    return array(//
                        'data-img-label' => $this->translator->trans('matejer_genspecs.ClotheGS.seven.' . $val . '.title'),
                        'data-img-src' => $this->loader->getImage('images/clothe-care/' . $val . '.png', 'clothegs', true),
                    );
                },
                'choices_as_values' => true,
            ))
            ->add('eight', ChoiceType::class, array(
                'choices'=>$this->eight,
                'label' => 'matejer_genspecs.ClotheGS.eight.label',
                'attr' => array(
                    'class'=>'image-picker',
                ),
                'required' => false,
                'choice_attr' => function($val) {
                    return array(//
                        'data-img-label' => $this->translator->trans('matejer_genspecs.ClotheGS.eight.' . $val . '.title'),
                        'data-img-src' => $this->loader->getImage('images/clothe-care/' . $val . '.png', 'clothegs', true),
                    );
                },
                'choices_as_values' => true,
            ))
            ->add('nine',ChoiceType::class,array(
                'choices'=>$this->nine,
                'label' => 'matejer_genspecs.ClotheGS.nine.label',
                'attr' => array(
                    'class'=>'image-picker',
                ),
                'required' => false,
                'choice_attr' => function($val) {
                    return array(//
                        'data-img-label' => $this->translator->trans('matejer_genspecs.ClotheGS.nine.' . $val . '.title'),
                        'data-img-src' => $this->loader->getImage('images/clothe-care/' . $val . '.png', 'clothegs', true),
                    );
                },
                'choices_as_values' => true,
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
            'csrf_token_id' => 'clothe_gs',
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'abo_clothegs';
    }
}
