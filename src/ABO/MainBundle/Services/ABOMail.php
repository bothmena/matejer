<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ABO\MainBundle\Services;


use ABO\MainBundle\Entity\EmailShop;
use Symfony\Component\Security\Core\User\UserInterface;

class ABOMail{
    
    protected $email;
    protected $password;
    protected $mailer;
    protected $templating;
    protected $translator;

    public function __construct(\Swift_Mailer $mailer,$templating,$translator,$email,$password) {

        $this->mailer = $mailer;
        $this->email = $email;
        $this->password = $password;
        $this->templating = $templating;
        $this->translator = $translator;
    }
    
    public function changeUserMail(UserInterface $user) {
        
        $options = array(
            'method' => 'changeUserMail',
            'receiver' => $user->getEmail(),
            'subject' => $this->translator->trans('matejer_email.change_email.subject'),
            'from' => array($this->email => $this->translator->trans('matejer_email.support_signature')),
            'to' => array($user->getEmail(), $user->getEmail() => $user->getLastname().' '.$user->getFirstname() ),
            'template' => 'Email/changeUserMail.html.twig',
            'options' => array('user'=>$user),
        );
        
        $this->sendMail($options);
    }
    
    public function emailReplaced(UserInterface $user) {
        
        $options = array(
            'method' => 'emailReplaced',
            'receiver' => $user->getEmail(),
            'subject' => $this->translator->trans('matejer_email.email_replaced.subject'),
            'from' => array($this->email => $this->translator->trans('matejer_email.support_signature')),
            'to' => array($user->getEmail(), $user->getEmail() => $user->getLastname().' '.$user->getFirstname() ),
            'template' => 'Email/emailReplaced.html.twig',
            'options' => array('user'=>$user),
        );
        
        $this->sendMail($options);
    }
    
    public function resettingPassword(UserInterface $user) {
        
        $options = array(
            'method' => 'resettingPassword',
            'receiver' => $user->getEmail(),
            'subject' => $this->translator->trans('matejer_email.resetting_password.subject'),
            'from' => array($this->email => $this->translator->trans('matejer_email.support_signature')),
            'to' => array($user->getEmail(), $user->getEmail() => $user->getLastname().' '.$user->getFirstname() ),
            'template' => 'Email/resettingPassword.html.twig',
            'options' => array('user'=>$user),
        );
        
        $this->sendMail($options);
    }
    
    public function emailConfirmed(UserInterface $user) {
        
        $options = array(
            'method' => 'emailConfirmed',
            'receiver' => $user->getEmail(),
            'subject' => $this->translator->trans('matejer_email.mail_confirmed.subject'),
            'from' => array($this->email => $this->translator->trans('matejer_email.support_signature')),
            'to' => array($user->getEmail(), $user->getEmail() => $user->getLastname().' '.$user->getFirstname() ),
            'template' => 'Email/emailConfirmed.html.twig',
            'options' => array('user'=>$user),
        );
        
        $this->sendMail($options);
    }
    
    public function userConfirmation(UserInterface $user) {
        
        $to = empty($user->getNewEmail()) ? $user->getEmail() : $user->getNewEmail();
        $options = array(
            'method' => 'userConfirmation',
            'receiver' => $to,
            'subject' => $this->translator->trans('matejer_email.confirm_user.subject'),
            'from' => array($this->email => $this->translator->trans('matejer_email.support_signature')),
            'to' => array($to, $to => $user->getLastname().' '.$user->getFirstname() ),
            'template' => 'Email/userConfirmation.html.twig',
            'options' => array('user'=>$user),
        );
        
        $this->sendMail($options);
        
    }
    
    public function welcomeUser(UserInterface $user) {
        
        $to = $user->getEmail();
        $options = array(
            'method' => 'welcomeShop',
            'receiver' => $to,
            'subject' => $this->translator->trans('matejer_email.welcome_user.subject'),
            'from' => array($this->email => $this->translator->trans('matejer_email.support_signature')),
            'to' => array( $to, $to => $user->getName() ),
            'template' => 'Email/welcomeUser.html.twig',
            'options' => array('user'=>$user),
        );
        
        return $this->sendMail($options);
    }
    
    public function shopConfirmation(UserInterface $user,EmailShop $email) {
        
        $shopname = $email->getShop()->getName();
        $mail = $email->getEmail();
        
        $options = array(
            'method' => 'shopConfirmation',
            'receiver' => $mail,
            'subject' => $this->translator->trans('matejer_email.confirm_user.subject'),
            'from' => array($this->email => $this->translator->trans('matejer_email.support_signature')),
            'to' => array($mail, $mail => $shopname ),
            'template' => 'Email/shopConfirmation.html.twig',
            'options' => array('user'=>$user, 'email'=>$email),
        );
        
        $this->sendMail($options);
    }
    
    public function welcomeShop(UserInterface $user,EmailShop $email) {
        
        $shopname = $email->getShop()->getName();
        $email = $email->getEmail();
        
        $options = array(
            'method' => 'welcomeShop',
            'receiver' => $email,
            'subject' => $this->translator->trans('matejer_email.welcome_shop.subject'),
            'from' => array($this->email => $this->translator->trans('matejer_email.support_signature')),
            'to' => array($email, $email => $shopname ),
            'template' => 'Email/welcomeShop.html.twig',
            'options' => array('user'=>$user),
        );
        
        $this->sendMail($options);
    }

    public function contactUs( $email, $name, $subject, $message ) {

        $options = array(
            'subject' => $subject,
            'from' => array($this->email => $this->translator->trans('matejer_email.support_signature')),
            'to' => array('contact@matejer.com', 'contact@matejer.com' => 'Contact Matejer' ),
            'template' => 'Email/contactUs.html.twig',
            'options' => array( 'email'=>$email, 'name'=>$name, 'subject'=>$subject, 'message'=>$message ),
        );

        $this->sendMail($options);
    }
    
    private function sendMail($arr) {
        
        $message = \Swift_Message::newInstance()
            ->setSubject($arr['subject'])
            ->setFrom($arr['from'])
            ->setTo($arr['to'])
            ->setBody($this->templating->render($arr['template'],$arr['options']),'text/html');
        
        $result = $this->mailer->send($message);
        
        return $result;
    }
}
