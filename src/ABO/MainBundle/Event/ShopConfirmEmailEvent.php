<?php

namespace ABO\MainBundle\Event;

use ABO\MainBundle\Entity\EmailShop;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Security\Core\User\UserInterface;

class ShopConfirmEmailEvent extends Event {

    private $user;
    private $email;
    
    public function __construct(UserInterface $user, EmailShop $email){
        
        $this->user = $user;
        $this->email = $email;
    }
    
    public function getUser(){
        
        return $this->user;
    }
    
    public function getEmail(){
        
        return $this->email;
    }
    
    public function getShop(){
        
        return $this->email->getShop();
    }
}
