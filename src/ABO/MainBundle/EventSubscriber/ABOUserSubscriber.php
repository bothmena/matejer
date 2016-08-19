<?php

namespace ABO\MainBundle\EventSubscriber;

use ABO\MainBundle\Entity\Address;
use ABO\MainBundle\Event\ABOResettingRequestInitializeEvent;
use ABO\MainBundle\Services\ABOMail;
use ABO\MainBundle\Services\ABOUniqueness;
use ABO\UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\UserEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ABOUserSubscriber implements EventSubscriberInterface {

    private $em;
    private $unique;
    private $mailer;
    
    public function __construct(EntityManager $em, ABOUniqueness $unique, ABOMail $mail){
    
        $this->em = $em;
        $this->unique = $unique;
        $this->mailer = $mail;
    }
    
    public static function getSubscribedEvents() {
        
        // return the subscribed events, their methods and priorities
        return array(
           'fos_user.registration.initialize' => array(
               array('onRegistrationInitialize'),
           ),
           'fos_user.registration.completed' => array(
               array('onRegistrationCompleted'),
           ),
           'abo.resetting_request_initialize' => array(
               array('onResettingRequestInitialize'),
           ),
        );
    }
    
    public function onResettingRequestInitialize(ABOResettingRequestInitializeEvent $event){

        /** @var User $user */
        $user = $event->getUser();
        if($user->isEnabled()){
            if($user->isLocked())
                $state = 'ACCOUNT_LOCKED';
            else if($user->isPrimaryEmailConfirmed())
                $state = 'ACCOUNT_CONFIRMED';
            else
                $state = 'ACCOUNT_UNCONFIRMED';
        }
        else
            $state = 'ACCOUNT_DISABLED';
        
        $event->setUserState($state);
    }
    
    public function onRegistrationInitialize(UserEvent $event) {

        /** @var User $user */
        $user = $event->getUser();
        $user->setFolder( $this->unique->getUnique('ABOUserBundle:User','folder') );
    
        return $user;
    }
    
    public function onRegistrationCompleted(FilterUserResponseEvent $event) {

        /** @var User $user */
        $user = $event->getUser();
        $user->setAddress( new Address() );
        $this->setDefaultImage($user);
        $this->setConfirmation($user);
    
        $this->em->persist($user);
        $this->em->flush();
    
        return $user;
    }
    
    private function setDefaultImage(User $user){
    
        $rep = $this->em->getRepository('ABOMainBundle:Image');
        if($user->getGender() === 'female')
            $user->setImage( $rep->find(2) );
        else
            $user->setImage( $rep->find(1) );
    }
    
    private function setConfirmation(User $user) {
    
        $user->setConfirmationToken( $this->unique->getUniqueToken('ABOUserBundle:User','confirmationToken') );
        $expiresAt = new \DateTime();
        $expiresAt->add(new \DateInterval('P3D'));
        $user->setExpiresAt($expiresAt);
        //email
        $this->mailer->userConfirmation($user);
        $this->mailer->welcomeUser($user);
    }
}
