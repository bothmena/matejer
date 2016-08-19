<?php

namespace ABO\MainBundle\Event;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\EventDispatcher\Event;


class ABOResettingRequestInitializeEvent extends Event {
    
    private $user;
    private $user_state;
    
    public function __construct(UserInterface $user){
        
        $this->user = $user;
    }
    
    public function getUser(){
        
        return $this->user;
    }
    
    public function getUserState(){
        
        return $this->user_state;
    }
    
    public function setUserState($state){
        
        $this->user_state = $state;
    }
}
