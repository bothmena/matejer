<?php

namespace ABO\MainBundle\Event;

use ABO\MainBundle\Entity\EmailShop;
use ABO\ShopBundle\Entity\Shop;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Security\Core\User\UserInterface;

class ShopRegistrationSuccessEvent extends Event {

    private $user;
    private $shop;
    private $email;
    
    public function __construct(UserInterface $user, Shop $shop, EmailShop $email){
        
        $this->user = $user;
        $this->shop = $shop;
        $this->email = $email;
    }
    
    public function getUser(){
        
        return $this->user;
    }
    
    public function getShop(){
        
        return $this->shop;
    }
    
    public function getEmail(){
        
        return $this->email;
    }
}
