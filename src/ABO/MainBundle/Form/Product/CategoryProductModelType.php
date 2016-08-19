<?php

namespace ABO\MainBundle\Form\Product;

use ABO\MainBundle\Entity\Category;
use ABO\MainBundle\Form\EventListener\GeneralSpecsSubscriber;
use ABO\MainBundle\Form\MultiImageType;
use ABO\MainBundle\Form\Specification\ColorType;
use ABO\TrademarkBundle\Entity\Trademark;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryProductModelType extends AbstractType {

    private     $category;
    private     $trademark;
    private     $colors;
    private     $clothes = array(
        'TopMan','BottomMan','ShoesMan','TopWoman','BottomWoman', 'ShoesWoman','UnderwearWoman',
        'TopBoy','BottomBoy','ShoesBoy','TopGirl','BottomGirl', 'ShoesGirl','TopBaby','BottomBaby',
        'ShoesBaby'
    );
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $this->category = $options['category'];
        $this->trademark = $options['trademark'];
        $this->colors = $options['colors'];

        $builder
            ->add('product', ProductType::class)
            ->add('arrangement', EntityType::class, array(
                'class' => 'ABOTrademarkBundle:Arrangement',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('a')
                        ->orWhere('a.category IS NULL')
                        ->orWhere('a.category = :category')
                        ->andWhere('a.trademark = :tm')
                        ->andWhere('a.toProduct = 1')
                        ->setParameters(array('tm' => $this->trademark, 'category'=> $this->category ))
                        ->orderBy('a.name', 'ASC');
                },
                'choice_label' => 'name',
                'empty_data' => null,
                'label' => 'matejer_product.arrangement_label',
                'placeholder' => 'matejer_product.arrangement_placeholder',
                'required'    => false,
                'attr' => array(
                    'class' => 'form-control',
                    'style' => 'width: 100%;',
                ),
                'translation_domain' => 'messages',
            ))
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
                'choice_label' => 'name',
                'multiple'=>true,
                'mapped' => false,
                'required'    => false,
                'choice_translation_domain' => 'messages',
                'empty_data' => array(),
                'attr' => array(
                    'class' => 'form-control select_two_multi'
                ),
            ))
            ->add('colors', CollectionType::class, array(
                'label' => 'matejer_product.color',
                'entry_type'   => ColorType::class,
                'mapped' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ))
            ->add('image', MultiImageType::class, array(
                'mapped'=>false,
                'isRequired'=>false,
            ))
            ->add('afterSubmit',ChoiceType::class,array(
                'choices' => array(
                    'matejer_product.after_submit.same_mod'      => 'same_mod',
                    'matejer_product.after_submit.same_cat'      => 'same_cat',
                    'matejer_product.after_submit.prod_specs'    => 'prod_specs',
                    'matejer_product.after_submit.new_cat'       => 'new_cat',
                    'matejer_product.after_submit.tm_home'       => 'tm_home',
                ),
                'expanded' => false,
                'mapped' => false,
                'attr' => array(
                    'class' => 'form-control',
                    'style' => 'width: 100%;',
                ),
            ))
            ->addEventSubscriber(new GeneralSpecsSubscriber($this->category))
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();

            if( !empty($this->colors) )
                $form->add('parentColors', EntityType::class, array(
                    'label' => 'matejer_product.color',
                    'class' => 'ABOMainBundle:Color',
                    'choices' => $this->colors,
                    'choice_label'=>'code',
                    'mapped' => false,
                    'multiple' => true,
                    'expanded' => true,
                ));

            if (in_array($this->category->getSpecsClass(), $this->clothes)) {
                $form->add('generalSpecs', 'clothegs');
            }
        });
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ABO\MainBundle\Entity\CategoryProduct',
            'cascade_validation' => true,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'category_product_model',
            'category' => null,
            'trademark' => null,
            'colors' => null,
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'abo_mainbundle_categoryproduct';
    }
}
