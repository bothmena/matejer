<?php

namespace ABO\MainBundle\EventSubscriber;

use ABO\MainBundle\Event\ShopRegistrationSuccessEvent;
use ABO\MainBundle\Services\ABOMail;
use ABO\MainBundle\Services\ABOUniqueness;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ABOShopSubscriber implements EventSubscriberInterface {
    
    private $unique;
    private $mailer;
    
    public function __construct(ABOUniqueness $unique, ABOMail $mailer){
        
        $this->unique = $unique;
        $this->mailer = $mailer;
    }
    
    public static function getSubscribedEvents() {
        
        // return the subscribed events, their methods and priorities
        return array(
           'abo.shop_registration_success' => array(
               array('onRegistrationSuccess'),
           ),
//            'abo.shop_new_offer' => array(
//                array('onNewEmailShop'),
//            ),
//            'abo.shop_offer_edit' => array(
//                array('onShopConfirmEmail'),
//            ),
//            'abo.shop_new_product' => array(
//                array('onShopConfirmEmail'),
//            ),
//            'abo.shop_new_collection' => array(
//                array('onShopConfirmEmail'),
//            ),
//            'abo.shop_discount' => array(
//                array('onShopConfirmEmail'),
//            ),
//            'abo.shop_new_review' => array(
//                array('onShopConfirmEmail'),
//            ),
        );
    }
    
    public function onRegistrationSuccess(ShopRegistrationSuccessEvent $event) {
    
        $user = $event->getUser();
        $email = $event->getEmail();
        $shop = $event->getShop();
        
        $shop->setFolder($this->unique->getUnique('ABOShopBundle:Shop', 'folder'));
        
        $this->mailer->welcomeShop($user, $email);
    }
}
