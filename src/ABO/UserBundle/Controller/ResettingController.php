<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ABO\UserBundle\Controller;

use ABO\MainBundle\Event\ABOMatejerEvents;
use ABO\MainBundle\Event\ABOResettingRequestInitializeEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Type\ResettingFormType;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Controller managing the resetting of the password
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Christophe Coevoet <stof@notk.org>
 */
class ResettingController extends Controller {
    
    /**
     * Request reset user password: show form
     * @Route("/request", methods={"GET"})
     */
    public function requestAction() {
        
        if($this->getUser())
            return $this->redirect ($this->generateUrl ('abo_user_profile_show'));
        return $this->render('FOSUserBundle:Resetting:request.html.twig',['user' => []]);
    }
    
    /**
     * Request reset user password: submit form and send email
     * @Route("/request/send-code", methods={"GET", "POST"})
     */
    public function sendConfirmCodeAction(Request $request) {
        
        if($this->getUser())
            return $this->redirect ($this->generateUrl ('abo_user_profile_show'));
        $form = $this->createFormBuilder()
            ->add('email', 'email', array(
                'attr'=>array(
                    'placeholder'=>'matejer_email.email',
                    'class'=>'form-control',
                ),
            ))->getForm();
        
        if($request->getMethod() === 'POST'){
            $form->handleRequest($request);
            $email = $form->get('email')->getData();
            $user = $this->get('fos_user.user_manager')->findUserByEmail($email);
            if (null === $user || null === $user->getConfirmationToken()) {
                return $this->render('FOSUserBundle:Resetting:sendConfirmCode.html.twig', array(
                    'invalid_email' => true,
                    'form' => $form->createView()
                ));
            }
            $this->get('abo.mail')->userConfirmation($user);
            return $this->render('FOSUserBundle:Resetting:sendConfirmCode.html.twig', array(
                'email' => $this->getObfuscatedEmail($user)
            ));
        }
        
        return $this->render('FOSUserBundle:Resetting:sendConfirmCode.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    /**
     * @Route("/request/code-sent", methods={"GET"})
     */
    public function codeSentAction($email) {
        if($this->getUser())
            return $this->redirect ($this->generateUrl ('abo_user_profile_show'));
        return $this->render('FOSUserBundle:Resetting:codeSent.html.twig', ['email' => $email]);
    }

    /**
     * Request reset user password: submit form and send email
     * @Route("/send-email", methods={"POST"})
     */
    public function sendEmailAction(Request $request) {
        
        if($this->getUser())
            return $this->redirect ($this->generateUrl ('abo_user_profile_show'));
        $username = $request->request->get('username');

        /** @var $user UserInterface */
        $user = $this->get('fos_user.user_manager')->findUserByUsernameOrEmail($username);

        if (null === $user) {
            return $this->render('FOSUserBundle:Resetting:request.html.twig', array(
                'invalid_username' => $username
            ));
        }
        
        $event = new ABOResettingRequestInitializeEvent($user);
        $this->get('event_dispatcher')->dispatch(ABOMatejerEvents::RESETTING_REQUEST_INITIALIZE, $event);

        $userState = $event->getUserState();

        switch($userState){
            case 'ACCOUNT_CONFIRMED':
                return $this->accountConfirmed($user);
            case 'ACCOUNT_LOCKED':
                return $this->render('FOSUserBundle:Resetting:accountLocked.html.twig');
            case 'ACCOUNT_UNCONFIRMED':
                return $this->render('FOSUserBundle:Resetting:accountUnconfirmed.html.twig');
            case 'ACCOUNT_DISABLED':
                return $this->render('FOSUserBundle:Resetting:accountDisabled.html.twig');
        }
    }

    /**
     * Tell the user to check his email provider
     * @Route("/check-email", methods={"GET"})
     */
    public function checkEmailAction(Request $request) {
        
        if($this->getUser())
            return $this->redirect ($this->generateUrl ('abo_user_profile_show'));
        $email = $request->query->get('email');

        if (empty($email)) {
            // the user does not come from the sendEmail action
            return new RedirectResponse($this->generateUrl('abo_user_resetting_request'));
        }

        return $this->render('FOSUserBundle:Resetting:checkEmail.html.twig', array(
            'email' => $email,
        ));
    }

    /**
     * Reset user password
     * @Route("/reset/{token}", methods={"GET", "POST"})
     */
    public function resetAction(Request $request, $token) {
        
        if($this->getUser())
            return $this->redirect ($this->generateUrl ('abo_user_change_password'));
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        //$formFactory = $this->get('fos_user.resetting.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $userManager->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException($this->get('translator')->trans('not_found.user_token', array('%token%'=>$token)));
        }

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::RESETTING_RESET_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        //$form = $formFactory->createForm();
        $form = $this->createForm(ResettingFormType::class, $user, array(
            'action' => $this->generateUrl('abo_user_resetting_reset', array('token'=>$token)),
        ));
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::RESETTING_RESET_SUCCESS, $event);
            $user->setPasswordRequestedAt(NULL);
            $userManager->updateUser($user);

            $response = new RedirectResponse($this->generateUrl('abo_user_profile_show'));
            $dispatcher->dispatch(FOSUserEvents::RESETTING_RESET_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render('FOSUserBundle:Resetting:reset.html.twig', array(
            'token' => $token,
            'form' => $form->createView(),
        ));
    }
    
    private function accountConfirmed($user) {
        
        if ($user->isPasswordRequestNonExpired($this->container->getParameter('fos_user.resetting.token_ttl'))) {
            return $this->render('FOSUserBundle:Resetting:passwordAlreadyRequested.html.twig');
        }

        if (null === $user->getConfirmationToken()) {
            
            $user->setConfirmationToken( $this->get('abo.uniqueness')->getUniqueToken('ABOUserBundle:User','confirmationToken') );
        }

        $this->get('abo.mail')->resettingPassword($user);
        $user->setPasswordRequestedAt(new \DateTime());
        $this->get('fos_user.user_manager')->updateUser($user);

        return new RedirectResponse($this->generateUrl('abo_user_resetting_checkemail',
            array('email' => $this->getObfuscatedEmail($user))
        ));
    }

    /**
     * Get the truncated email displayed when requesting the resetting.
     * The default implementation only keeps the part following @ in the address.
     * @param \FOS\UserBundle\Model\UserInterface $user
     * @return string
     */
    protected function getObfuscatedEmail(UserInterface $user) {
        
        $email = $user->getEmail();
        if (false !== $pos = strpos($email, '@')) {
            $email = '...' . substr($email, $pos);
        }

        return $email;
    }
}
