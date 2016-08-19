<?php

namespace ABO\MainBundle\Event;

use ABO\UserBundle\Entity\User;
use Symfony\Component\EventDispatcher\Event;

class UserChangeLanguageEvent extends Event {

    private $user;
    private $language;

    public function __construct(User $user = null, $language = 'fr'){
        
        $this->user = $user;
        $this->language = $language;
    }
    
    /**
     * Get categoryProduct
     *
     * @return \ABO\UserBundle\Entity\User
     */
    public function getUser() {
        
        return $this->user;
    }
    
    /**
     * Get form
     *
     * @return \Symfony\Component\Form\Form
     */
    public function getLanguage() {

        if($this->user !== null)
            return $this->user->getLanguage();
        else
            return $this->language;
    }
}
