<?php

namespace ABO\MainBundle\Form\GenSpecs;

use ABO\MainBundle\Form\GenSpecs\GeneralSpecType as BaseType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UnderwearWomanType extends BaseType {
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('uni', EntityType::class, array(
                'class' => 'ABOMainBundle:Size',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->where('s.type = :type')
                        ->setParameter('type', 'uni');
                },
                'choice_label' => 'value',
                'label' => 'matejer_size.uni',
                'required'    => false,
                'multiple' => true,
                'attr' => array(
                    'class' => 'form-control select_two_multi',
                    'style' => 'width: 100%;',
                ),
            ))
            ->add('fr', EntityType::class, array(
                'class' => 'ABOMainBundle:Size',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->where('s.type = :type')
                        ->andWhere('s.age = :age')
                        ->andWhere('s.sexe = :sexe')
                        ->andWhere('s.clothe = :clothe')
                        ->setParameters(array('type'=>'fr','age'=>'ad','sexe'=>'fm','clothe'=>'pn'));
                },
                'choice_label' => 'value',
                'label' => 'matejer_size.fr_pant',
                'required'    => false,
                'multiple' => true,
                'attr' => array(
                    'class' => 'form-control select_two_multi',
                    'style' => 'width: 100%;',
                ),
            ))
            ->add('eur', EntityType::class, array(
                'class' => 'ABOMainBundle:Size',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->where('s.type = :type')
                        ->andWhere('s.age = :age')
                        ->andWhere('s.sexe = :sexe')
                        ->andWhere('s.clothe = :clothe')
                        ->setParameters(array('type'=>'eur','age'=>'ad','sexe'=>'fm','clothe'=>'sg'));
                },
                'choice_label' => 'value',
                'label' => 'matejer_size.eur_sg',
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
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'underwear_woman',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'abo_mainbundle_general_specs';
    }
}
