<?php

namespace ABO\MainBundle\Form\EventListener;

use ABO\MainBundle\Entity\Address;
use ABO\MainBundle\Entity\Place;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

/**
 * Description of AddressUserSubscriber
 *
 * @author Aymen
 */
class AddressUserSubscriber implements EventSubscriberInterface {
    
    private $em;

    public function __construct(EntityManager $em) {
        
        $this->em = $em;
    }
    
    public static function getSubscribedEvents() {
        
        return array(
            FormEvents::PRE_SET_DATA => 'onPreSetData',
            FormEvents::PRE_SUBMIT   => 'onPreSubmit',
        );
    }
    
    public function onPreSetData(FormEvent $event) {

        $form = $event->getForm();
        $user = $event->getData();

        if($user && $user->getAddress())
            $address = $user->getAddress();
        else
            $address = null;
        /**
         * @var Address $address
         */
        if($address->getCountry())
            $this->addState($form, $address->getCountry());
        if($address->getState())
            $this->addCity($form, $address->getState());
    }

    public function onPreSubmit(FormEvent $event) {

        $form = $event->getForm();
        $data = $event->getData();


        if(isset($data['address'])){
            $address = $data['address'];

            if( !empty($address['country']) ) {
                $country =  $this->em->getRepository('ABOMainBundle:Place')->find($address['country']);
                if($country)
                    $this->addState($form, $country);
            }

            if( !empty($address['state']) ) {
                $state = $this->em->getRepository('ABOMainBundle:Place')->find($address['state']);
                if($state)
                    $this->addCity($form, $state);
            }
        }
    }

    private function addState(FormInterface $form, Place $country){

        $form->get('address')->add('state', EntityType::class, array(
            'class' => 'ABOMainBundle:Place',
            'required'    => false,
            'query_builder' => function(EntityRepository $er) use ($country) {
                return $er->createQueryBuilder('p')
                    ->join('p.parent','pa')
                    ->where('p.type = :type')
                    ->andWhere('p.parent = :parent')
                    ->setParameters(array('type'=>'state','parent'=>$country));
            },
            'choice_label' => 'translatable',
            'placeholder' => 'matejer_place.state_placeholder',
            'choice_translation_domain'=>'messages',
            'attr' => array(
                'class' => '__address_state form-control',
                'ng-model' => 'address.state',
                'ng-change' => 'refreshForm(\'state\')',
                'style' => 'width: 100%;'
            ),
        ));
    }

    private function addCity(FormInterface $form, Place $state){

        $form->get('address')->add('city', EntityType::class, array(
            'class' => 'ABOMainBundle:Place',
            'required'    => false,
            'query_builder' => function(EntityRepository $er) use ($state) {
                return $er->createQueryBuilder('p')
                    ->join('p.parent','pa')
                    ->where('p.type = :type')
                    ->andWhere('p.parent = :parent')
                    ->setParameters(array('type'=>'city','parent'=>$state));
            },
            'choice_label' => 'translatable',
            'placeholder' => 'matejer_place.city_placeholder',
            'choice_translation_domain'=>'messages',
            'attr' => array(
                'class' => '__address_city form-control',
                'style' => 'width: 100%;'
            ),
        ));
    }
}
