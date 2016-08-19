<?php

namespace ABO\TrademarkBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArrangementType extends AbstractType
{
    private $trademark;
    private $categories;

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $this->trademark = $options['trademark'];
        $this->categories = $options['categories'];

        $builder
            ->add('name',TextType::class,array(
                'required'    => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('category', EntityType::class, array(
                'class' => 'ABOMainBundle:Category',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where('c.id IN (:ids)')
                        ->setParameter('ids', $this->categories)
                        ->orderBy('c.parent');
                },
                'choice_label' => 'translatable',
                'group_by' => 'transParent',
                'choice_translation_domain' => 'messages',
                'placeholder' => 'Choose Category',
                'required'    => false,
                'attr' => array(
                    'class' => 'form-control select_two',
                    'style'=>"width: 100%;"
                ),
            ))
            ->add('parent', EntityType::class, array(
                'class' => 'ABOTrademarkBundle:Arrangement',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('a')
                        ->where('a.trademark = :tm')
                        ->andWhere('a.toProduct = :toProduct')
                        ->setParameters(array('tm'=> $this->trademark, 'toProduct'=> false))
                        ->orderBy('a.name', 'ASC');
                },
                'choice_label' => 'name',
                'placeholder' => 'Choose Arrangement Parent',
                'required'    => false,
                'attr' => array(
                    'class' => 'select_two form-control'
                ),
            ))
            ->add('description',TextareaType::class,array(
                'required'    => false,
                'empty_data'=>'',
                'attr'=>array(
                    "rows"          =>  "4",
                    "class"         =>  "form-control",
                    "style"         =>  "resize: none;",
                ),
            ))
            ->add('toProduct',CheckboxType::class,array(
                'required'    => false,
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ABO\TrademarkBundle\Entity\Arrangement',
            'cascade_validation' => true,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'arrangement',
            'trademark' => null,
            'categories' => array(),
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'abo_trademarkbundle_arrangement';
    }
}
