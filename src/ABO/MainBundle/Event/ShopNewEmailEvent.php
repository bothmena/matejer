<?php

namespace ABO\MainBundle\Event;

use ABO\MainBundle\Entity\EmailShop;
use ABO\ShopBundle\Entity\Shop;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Security\Core\User\UserInterface;

class ShopNewEmailEvent extends Event {

    private $user;
    private $email;
    private $shop;
    
    public function __construct(UserInterface $user, EmailShop $email, Shop $shop){
        
        $this->user = $user;
        $this->email = $email;
        $this->shop = $shop;
    }
    
    public function getUser(){
        
        return $this->user;
    }
    
    public function getEmail(){
        
        return $this->email;
    }
    
    public function getShop(){
        
        return $this->shop;
    }
}
