<?php

namespace ABO\MainBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class EmailSpoiledEvent extends Event {

    private $method;
    private $subject;
    private $receiver;
    
    public function __construct($method, $subject, $receiver){
        
        $this->method = $method;
        $this->subject = $subject;
        $this->receiver = $receiver;
    }
    
    public function getMethod() {
        
        return $this->method;
    }
    
    public function getSubject() {
        
        return $this->subject;
    }
    
    public function getReceiver() {
        
        return $this->receiver;
    }
}
