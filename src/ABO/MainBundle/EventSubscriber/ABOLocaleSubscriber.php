<?php

namespace ABO\MainBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ABOLocaleSubscriber implements EventSubscriberInterface {
    
    private $defaultLocale;

    public function __construct($defaultLocale = 'fr') {
        
        $this->defaultLocale = $defaultLocale;
    }
    
    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return array(
            KernelEvents::REQUEST => array(array('onKernelRequest', 17)),
            KernelEvents::RESPONSE => array(array('onKernelResponse', 17)),
        );
    }
    
    public function onKernelRequest(GetResponseEvent $event) {
        
        $request = $event->getRequest();
        if (!$request->hasPreviousSession()) {
            return;
        }

        // try to see if the locale has been set as a _locale routing parameter
        if ($locale = $request->attributes->get('_locale')) {
            $request->getSession()->set('_locale', $locale);
        } else {
            $request->setLocale($request->getSession()->get('_locale', $this->defaultLocale));
        }
    }
    
    public function onKernelResponse(FilterResponseEvent $event) {
        
        $locale = $event->getRequest()->getSession()->get('_locale', $this->defaultLocale);
        $event->getResponse()->headers->set('Content-Language', $locale);
    }
}
