<?php

namespace ABO\MainBundle\EventSubscriber;


use ABO\MainBundle\Event\UserChangeLanguageEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class ABOLoginSubscriber implements EventSubscriberInterface {
    
    private $session;

    public function __construct(Session $session) {
        
        $this->session = $session;
    }
    
    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return array(
            'security.interactive_login' => array(
                array('onInteractiveLogin'),
            ),
            'abo.user_change_language' => array(
                array('onLanguageChange'),
            ),
        );
    }
    
    public function onInteractiveLogin(InteractiveLoginEvent $event) {
        
        $user = $event->getAuthenticationToken()->getUser();

        if (null !== $user->getLanguage()) {
            $this->session->set('_locale', $user->getLanguage());
        }
    }
    
    public function onLanguageChange(UserChangeLanguageEvent $event) {

        $this->session->set('_locale', $event->getLanguage());
    }
}
