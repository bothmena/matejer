<?php

namespace ABO\MainBundle\EventSubscriber;

use ABO\MainBundle\Event\ShopConfirmEmailEvent;
use ABO\MainBundle\Event\ShopNewEmailEvent;
use ABO\MainBundle\Services\ABOMail;
use ABO\MainBundle\Services\ABOUniqueness;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ABOEmailSubscriber implements EventSubscriberInterface {
    
    private $unique;
    private $mailer;
    
    public function __construct(ABOUniqueness $unique, ABOMail $mailer){
        
        $this->unique = $unique;
        $this->mailer = $mailer;
    }
    
    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return array(
           'abo.shop_new_email' => array(
               array('onShopNewEmail'),
           ),
           'abo.shop_email_confirmation' => array(
               array('onShopConfirmEmail'),
           ),
        );
    }
    
    public function onShopNewEmail(ShopNewEmailEvent $event) {
    
        $user = $event->getUser();
        $email = $event->getEmail();
        $shop = $event->getShop();
        
        if($email->getEmail() != $user->getEmail()){
            
            $email->setCode($this->unique->getUnique('ABOMainBundle:EmailShop', 'code'));
            $email->setConfirmed(false);
            $deadline = new \DateTime();
            $deadline->add(new \DateInterval('P5D'));
            $email->setDeadline($deadline);
            $email->setShop($shop);
            
            $this->mailer->shopConfirmation($user, $email);
        }else {
            $email->setConfirmed(true);
            $email->setDeadline(new \DateTime());
            $email->setShop($shop);
            $email->setCode('');
        }
        
        return $email;
    }
    
    public function onShopConfirmEmail(ShopConfirmEmailEvent $event) {
    
    }
}
