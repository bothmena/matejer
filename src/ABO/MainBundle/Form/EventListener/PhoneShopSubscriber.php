<?php

namespace ABO\MainBundle\Form\EventListener;

use ABO\MainBundle\Form\Phone\PhoneShopType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * Description of PhoneShopSubscriber
 *
 * @author Aymen
 */
class PhoneShopSubscriber implements EventSubscriberInterface {
    
    private $em;

    public function __construct(EntityManager $em) {
        
        $this->em = $em;
    }
    
    public static function getSubscribedEvents() {
        
        return array(
            FormEvents::PRE_SET_DATA => 'onPreSetData',
        );
    }
    
    public function onPreSetData(FormEvent $event) {
        
        $form = $event->getForm();
        $shop = $event->getData();
        $phone_names = ['phone_one','phone_two','phone_three'];
        $phones = [];
        
        if($shop){
            $phones = $this->em->getRepository('ABOMainBundle:PhoneShop')->findByShop($shop);
        }
        
        foreach ($phone_names as $key=>$phone_name){
            
            if(isset($phones[$key]))
                $form->add($phone_name, PhoneShopType::class, array(
                    'mapped'=>false,
                    'number'=>$key,
                    'phone'=>$phones[$key],
                ));
            else
                $form->add($phone_name, PhoneShopType::class, array(
                    'mapped'=>false,
                    'number'=>$key,
                ));
            
        }
    }
}
