<?php

namespace ABO\MainBundle\Form\GenSpecs;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShoesBabyType extends AbstractType {
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder
            ->add('fr', EntityType::class, array(
                'class' => 'ABOMainBundle:Size',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->where('s.type = :type')
                        ->andWhere('s.age = :age')
                        ->andWhere('s.sexe = :sexe')
                        ->andWhere('s.clothe = :clothe')
                        ->setParameters(array('type'=>'fr','age'=>'bb','sexe'=>'mf','clothe'=>'sh'));
                },
                'choice_label' => 'value',
                'label' => 'matejer_size.fr',
                'required'    => false,
                'multiple' => true,
                'attr' => array(
                    'class' => 'form-control select_two_multi',
                    'style' => 'width: 100%;',
                ),
            ))
            ->add('age', EntityType::class, array(
                'class' => 'ABOMainBundle:Size',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->where('s.type = :type')
                        ->andWhere('s.age = :age')
                        ->andWhere('s.sexe = :sexe')
                        ->andWhere('s.clothe = :clothe')
                        ->setParameters(array('type'=>'age','age'=>'bb','sexe'=>'mf','clothe'=>'st'));
                },
                'choice_label' => 'value',
                'label' => 'matejer_size.age',
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
            'csrf_token_id' => 'shoes_baby',
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
