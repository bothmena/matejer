<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ABO\MainBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\Security\Core\User\UserInterface;

class ABOPhoneEmail {

    private $em;
    private $unique;
    private $translator;
    private $error = false;
    
    public function __construct(EntityManager $manager, ABOUniqueness $unique, $translator) {
        
        $this->em = $manager;
        $this->unique = $unique;
        $this->translator = $translator;
    }

    public function submitPhoneEmail(Form $form, array $phones, array $emails, $owner){

        $result = [];
        $result['phones'] = $this->persistPhones($phones, $form, $owner);

        if( !$this->error )
            $result['emails'] = $this->persistEmails($emails, $form, $owner);

        if( !$this->error )
            $this->em->flush();

        return $result;
    }

    public function submitPhone(Form $form, array $phones, UserInterface $user){

        $result = $this->persistPhones($phones, $form, $user);

        if( !$this->error )
            $this->em->flush();

        return $result;
    }

    private function persistPhones(array $phones, Form $form, $owner) {

        $arr = ['phoneOne', 'phoneTwo', 'phoneThree'];
        $returnPhones = [];
        for($i = 0; $i < 3; $i++){
            $subscriber = $form->get($arr[$i])->get('subscriber')->getData();
            if(empty($subscriber)){
                if(!empty($phones[$i]))
                    $this->em->remove($phones[$i]);
            }else{
                if( !empty($phones[$i]) && $subscriber === $phones[$i]->getSubscriber() )
                    array_push($returnPhones, $phones[$i]);
                else if($this->isPhoneUnique($subscriber, $owner->getClassName())){
                    if( empty($phones[$i]) ) {
                        $phones[$i] = $form->get($arr[$i])->getData();
                        $phones[$i]->setPhoneCode('+216');
                        $this->setOwner($phones[$i], $owner);
                    }
                    else
                        $phones[$i]->setSubscriber($subscriber);
                    $this->em->persist($phones[$i]);
                    array_push($returnPhones, $phones[$i]);
                }
                else{
                    $this->throwPhoneError($form, $arr[$i], $owner->getClassName());
                    $this->error = true;
                }
            }
        }
        return $returnPhones;
    }

    private function persistEmails(array $emails, Form $form, $owner) {

        $arr = ['emailOne', 'emailTwo', 'emailThree'];
        $returnEmails = [];
        for($i = 0; $i < 3; $i++){
            $emailValue = $form->get($arr[$i])->get('email')->getData();
            if(empty($emailValue)){
                if(!empty($emails[$i]))
                    $this->em->remove($emails[$i]);
            }else{
                if(!empty($emails[$i]) && $emailValue === $emails[$i]->getEmail() )
                    array_push($returnEmails, $emails[$i]);
                else if($this->isEmailUnique($emailValue, $owner->getClassName())){
                    if( empty($emails[$i]) ){
                        $emails[$i] = $form->get($arr[$i])->getData();
                        $this->setOwner($emails[$i], $owner);
                    }
                    else
                        $emails[$i]->setEmail($emailValue);
                    $this->em->persist($this->setEmailToken($emails[$i], $owner->getClassName()));
                    array_push($returnEmails, $emails[$i]);
                }
                else{
                    $this->throwEmailError ($form, $arr[$i], $owner->getClassName());
                    $this->error = true;
                }
            }
        }
        return $returnEmails;
    }

    private function isPhoneUnique($subscriber, $ownerClass) {

        if($ownerClass === 'UserEntity')
            return $this->unique->isAvailable('ABOMainBundle:PhoneUser', 'subscriber', $subscriber);
        else if($ownerClass === 'ShopEntity')
            return $this->unique->isAvailable('ABOMainBundle:PhoneShop', 'subscriber', $subscriber);
    }

    private function throwPhoneError(Form $form, $name, $ownerClass) {

        if($ownerClass === 'UserEntity')
            $form->get($name)->get('subscriber')->addError (new FormError($this->translator->trans('phone_user.subscriber.unique', array(), 'validators' )));
        else if($ownerClass === 'ShopEntity')
            $form->get($name)->get('subscriber')->addError (new FormError($this->translator->trans('phone_shop.subscriber.unique', array(), 'validators' )));
    }

    private function setOwner($entity, $owner) {

        switch ( $owner->getClassName() ){
            case 'ShopEntity':
                $entity->setShop($owner);
                break;
            case 'UserEntity':
                $entity->setUser($owner);
                break;
            case 'TrademarkEntity':
                $entity->setTrademark($owner);
                break;
        }
    }

    private function isEmailUnique($email, $ownerClass) {

        if($ownerClass === 'ShopEntity')
            return $this->unique->isAvailable('ABOMainBundle:EmailShop', 'email', $email);
        else if($ownerClass === 'TrademarkEntity')
            return $this->unique->isAvailable('ABOMainBundle:EmailTrademark', 'email', $email);
    }

    private function setEmailToken($email, $ownerClass) {

        if($ownerClass === 'ShopEntity')
            $email->setCode($this->unique->getUnique('ABOMainBundle:EmailShop', 'code'));
        else if($ownerClass === 'TrademarkEntity')
            $email->setCode($this->unique->getUnique('ABOMainBundle:EmailTrademark', 'code'));
        return $email;
    }

    private function throwEmailError(Form $form, $name, $ownerClass) {

        if($ownerClass === 'ShopEntity')
            $form->get($name)->get('email')->addError (new FormError($this->translator->trans('email_shop.email.unique', array(), 'validators' )));
        else if($ownerClass === 'TrademarkEntity')
            $form->get($name)->get('email')->addError (new FormError($this->translator->trans('email_trademark.email.unique', array(), 'validators' )));
    }
    
    public function getName() {
        
        return 'ABOPhoneEmail';
    }
}
