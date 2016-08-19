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

use ABO\MainBundle\Entity\ImageUser;
use ABO\UserBundle\Form\ConfirmedFormType;
use ABO\UserBundle\Form\Type\RegistrationFormType;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Controller managing the registration
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Christophe Coevoet <stof@notk.org>
 */
class RegistrationController extends BaseController {
    
    /**
     * @Route("/register", methods={"GET", "POST"})
     */
    public function registerAction(Request $request) {
        
        if($this->getUser())
            return $this->redirect ($this->generateUrl ('abo_user_profile_show'));
        
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        //$formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $userManager->createUser();
        $user->setEnabled(true);
        
        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $this->createForm(RegistrationFormType::class, $user, array(
            'action' => $this->generateUrl('abo_user_registration_register'),
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

            $userManager->updateUser($user);

            $response = new RedirectResponse($this->generateUrl('abo_user_registration_confirmed'));

            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render('FOSUserBundle:Registration:register.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/register/confirmed", methods={"GET", "POST"}, name="abo_user_registration_confirmed")
     * @Security("has_role('ROLE_USER')")
     */
    public function confirmedRegAction(Request $request) {
        
        $user = $this->getUser();

        $now = new \DateTime(); $nowT = $now->getTimestamp();
        $inscri = $user->getInscriptionDate(); $inscriT = $inscri->getTimestamp();
        if($nowT - $inscriT > 3600)
            return new RedirectResponse($this->generateUrl('abo_user_profile_show'));
        
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(ConfirmedFormType::class, $user, array(
            'action' => $this->generateUrl('abo_user_registration_confirmed'),
        ));
        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {

                if(!empty($form->get('image')->getData())){
                    $image = $this->get('abo.file_uploader')->handleImage($form->get('image')->getData(), $user->getFolder(), 'user', 'profile' );
                    $user->setImage($image);
                    $imgUser = new ImageUser();
                    $imgUser->setImage($image);
                    $imgUser->setUser($user);
                    $em->persist($imgUser);
                }
                $em->persist($user); 
                $em->flush();
                return $this->redirect($this->generateUrl('abo_user_profile_show'));
            }
        }
        
        return $this->render('FOSUserBundle:Registration:confirmed.html.twig',array(
            'form'=>$form->createView(),
        ));
    }
    
    /**
     * @Route("/register/confirm/{token}", methods={"GET"})
     */
    public function confirmAction(Request $request, $token) {
        
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException($this->get('translator')->trans('not_found.user_token', array('%token%'=>$token)));
        }

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');
        
        if( $user->getNewEmail() !== null && $user->getNewEmail() !== '' ) {
            $user->setEmail($user->getNewEmail());
            $user->setNewEmail(null); 
        }
        $user->setConfirmationToken(NULL);
        $user->setLocked(false);
        $user->setExpired(false);
        $user->setExpiresAt(NULL);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_CONFIRM, $event);

        $userManager->updateUser($user);
        $response = new RedirectResponse($this->generateUrl('abo_user_profile_show'));
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_CONFIRMED, new FilterUserResponseEvent($user, $request, $response));

        return $response;
    }
}
