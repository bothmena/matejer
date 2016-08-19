<?php

namespace ABO\MainBundle\Form\Product;

use ABO\MainBundle\Entity\Category;
use ABO\ShopBundle\Entity\CollectionRepository;
use ABO\ShopBundle\Entity\PaymentRepository;
use ABO\ShopBundle\Entity\Shop;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfferType extends AbstractType
{
    private $shop;
    private $category;
    private $collections;
    private $payments;
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $this->shop = $options['shop'];
        $this->category = $options['category'];
        $this->collections = $options['collections'];
        $this->payments = $options['payments'];

        $builder
            ->add('reference',TextType::class,array(
                'required'    => true,
                'label' => 'matejer_offer.reference',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('price',NumberType::class,array(
                'required' => true,
                'label' => 'matejer_offer.price',
                'scale'=>2,
                'attr' => array(
                    'class' => 'form-control',
                    'has-addon' => 'true',
                    'data-addon'=>  'matejer_currency.'.$this->shop->getCurrency(),
                    'aria-describedby' => 'basic-addon1',
                ),
            ))
            ->add('discount',NumberType::class,array(
                'required' => true,
                'label' => 'matejer_offer.discount',
                'scale'=>2,
                'attr' => array(
                    'class' => 'form-control',
                    'has-addon' => 'true',
                    'aria-describedby' => 'basic-addon2',
                    'data-addon'=>  '%',
                ),
            ))
            ->add('warranty',IntegerType::class,array(
                'label' => 'matejer_offer.warranty',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                    'min'        => '0',
                    'has-addon' => 'true',
                    'aria-describedby' => 'basic-addon3',
                    'data-addon'=>  'matejer_main.months',
                ),
            ))
            ->add('availability',ChoiceType::class,array(
                'required' => TRUE,
                'label' => 'matejer_offer.availability',
                'choices' => array(
                    'matejer_offer.avai_choices.stock' => 'stock',
                    'matejer_offer.avai_choices.comnd' => 'comnd',
                    'matejer_offer.avai_choices.avasn' => 'avasn',
                    'matejer_offer.avai_choices.unava' => 'unava',
                ),
                'choice_translation_domain'=>'messages',
                'attr' => array(
                    'class' => 'form-control',
                    'style' => 'width: 100%;',
                ),
            ))
            ->add('collection', EntityType::class, array(
                'label' => 'matejer_offer.collection',
                'class' => 'ABOShopBundle:Collection',
                'query_builder' => function(CollectionRepository $er) {
                    return $er->getCollections($this->shop,$this->category);
                },
                'choice_attr' => function($val, $key, $index) {
                    if( in_array($val, $this->collections) )
                        return ['selected' => ''];
                    else
                        return [];
                },
                'choice_label' => 'name',
                'mapped' => false,
                'empty_data' => array(),
                'required'    => false,
                'multiple' => true,
                'attr' => array(
                    'class' => 'form-control select_two_multi',
                    'style' => 'width: 100%;',
                ),
            ))
            ->add('payment', EntityType::class, array(
                'label' => 'matejer_offer.payment',
                'class' => 'ABOShopBundle:Payment',
                'query_builder' => function(PaymentRepository $er) {
                    return $er->getPayments($this->shop);
                },
                'choice_attr' => function($val, $key, $index) {
                    if( in_array($val, $this->payments) )
                        return ['selected' => ''];
                    else
                        return [];
                },
                'choice_label' => 'description',
                'mapped' => false,
                'empty_data' => array(),
                'required'    => false,
                'multiple' => true,
                'attr' => array(
                    'class' => 'form-control select_two_multi',
                    'style' => 'width: 100%;',
                ),
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {

        $resolver->setDefaults(array(
            'data_class' => 'ABO\MainBundle\Entity\ProductShop',
            'cascade_validation' => true,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'offer',
            'shop'=>null,
            'category'=>null,
            'collections'=>array(),
            'payments'=>array(),
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'abo_mainbundle_productshop';
    }
}
