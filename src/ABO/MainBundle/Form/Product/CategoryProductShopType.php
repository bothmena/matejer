<?php

namespace ABO\MainBundle\Form\Product;

use ABO\MainBundle\Entity\Category;
use ABO\MainBundle\Form\EventListener\GeneralSpecsSubscriber;
use ABO\MainBundle\Form\GenSpecs\ClotheGSType;
use ABO\MainBundle\Form\MultiImageType;
use ABO\MainBundle\Form\Specification\ColorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryProductShopType extends AbstractType {

    private     $category;
    private     $tms;
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
        $this->tms = $options['tms'];

        $builder
            ->add('product', ProductType::class)
            ->add('colors', CollectionType::class, array(
                'label' => 'matejer_product.color',
                'entry_type'   => ColorType::class,
                'mapped' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ))
            ->add('image', MultiImageType::class, array(
                'mapped'=>false,
            ))
            ->add('afterSubmit',ChoiceType::class,array(
                'choices' => array(
                    'matejer_product.after_submit.offer' => 'offer',
                    'matejer_product.after_submit.same_cat' => 'same_cat',
                    'matejer_product.after_submit.new_cat' => 'new_cat',
                    'matejer_product.after_submit.shop_home' => 'shop_home',
                ),
                'label' => 'matejer_product.after_submit.label',
                'translation_domain' => 'messages',
                'choice_translation_domain' => 'messages',
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

            if (in_array($this->category->getSpecsClass(), $this->clothes)) {
                $form->add('generalSpecs', ClotheGSType::class);
            }
            if(!empty($this->tms)){
                $form->add('trademark', EntityType::class, array(
                    'class' => 'ABOTrademarkBundle:Trademark',
                    'choices' => $this->tms,
                    'property' => 'name',
                    'empty_data' => 'null',
                    'label' => 'matejer_product.trademark_label',
                    'empty_value' => 'matejer_product.trademark_placeholder',
                    'required'    => false,
                    'attr' => array(
                        'class' => 'form-control',
                        'style' => 'width: 100%;',
                    ),
                    'translation_domain' => 'messages',
                ));
            }
            $form->get('product')->add('mark',TextType::class,array(
                'label'=> empty($this->tms) ? 'matejer_product.mark_label_empty' : 'matejer_product.mark_label',
                'translation_domain' => 'messages',
                'required' => FALSE,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ));
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
            'csrf_token_id' => 'category_product_shop',
            'category' => null,
            'tms' => array(),
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
