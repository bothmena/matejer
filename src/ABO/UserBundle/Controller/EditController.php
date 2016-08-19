<?php

namespace ABO\UserBundle\Controller;

use ABO\MainBundle\Event\ABOMatejerEvents;
use ABO\MainBundle\Event\UserChangeLanguageEvent;
use ABO\UserBundle\Form\NewEmailType;
use ABO\UserBundle\Form\ProfileImageType;
use ABO\UserBundle\Form\UserAddressType;
use ABO\UserBundle\Form\UserPersonalType;
use ABO\UserBundle\Form\UserPhoneType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
 * @Cache(public=false, maxage="0", smaxage="0")
 * @Route("/myProfile", methods={"GET"})
 */
class EditController extends Controller {

    /**
     * @Route("/edit", name="abo_user_profile_edit")
     */
    public function editAction(){

        $user = $this->getDoctrine()->getRepository('ABOUserBundle:User')
            ->getFullUser($this->getUser()->getId());
        
        $phones = $this->getDoctrine()->getRepository('ABOMainBundle:PhoneUser')->getPhones($user);
        
        return $this->render('FOSUserBundle:Profile:edit.html.twig', array(
            'user' =>$user,
            'phones' => $phones,
        ));
    }
    
    /**
     * @Route("/change-email", name="abo_user_profile_changeusermail", methods={"POST"})
     */
    public function changeUserMailAction(Request $request) {
        
        $user = $this->getUser();
        $form = $this->createForm(NewEmailType::class, $user, array(
            'action' => $this->generateUrl('abo_user_profile_changeusermail'),
            'method' => 'POST',
        ));
        
        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                
                $translator = $this->get('translator');
                $user_repo = $this->getDoctrine()->getRepository('ABOUserBundle:User');
                $userByEmail = $user_repo->findOneByEmail($form['current_email']->getData());
                $userByNewEmail =  $user_repo->findOneByEmail($form['new_email']->getData());
                if($userByNewEmail)
                    return $this->render('FOSUserBundle:Profile:changeUserMail.html.twig', array(
                        'form' => $form->createView(),
                        'new_email_error' => $translator->trans('matejer_email.change_email.new_email_error'),
                    ));
                
                if($user == $userByEmail){
                    
                    if(!empty($user->getConfirmationToken()) && empty($user->getNewEmail()))
                        $user->setEmail($form['new_email']->getData());
                    else
                        $user->setNewEmail($form['new_email']->getData());
                    if(empty($user->getConfirmationToken()))
                        $user->setConfirmationToken($this->get('abo.uniqueness')->getUniqueToken('ABOUserBundle:User','confirmationToken'));
                    $date = new \DateTime;
                    $user->setExpiresAt($date->add(new \DateInterval('P3D')));
                    $this->getDoctrine()->getManager()->flush();
                    
                    $mail = $this->get('abo.mail');
                    $mail->changeUserMail($user);
                    $mail->userConfirmation($user);
                    
                    return $this->redirectToRoute('abo_user_profile_show');
                    
                }else{
                    return $this->render('FOSUserBundle:Profile:changeUserMail.html.twig', array(
                        'form' => $form->createView(),
                        'email_error' => $translator->trans('matejer_email.change_email.email_error'),
                    ));
                }
            }
        }
        return $this->render('FOSUserBundle:Profile:changeUserMail.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    /**
     * @Route("/edit/general", name="abo_user_profile_generalform", methods={"POST"})
     */
    public function generalFormAction(Request $request) {
        
        $user = $this->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(UserPersonalType::class,$user, array(
            'action' => $this->generateUrl('abo_user_profile_generalform'),
            'user' => $user,
        ));
        $response = ['stat'=>''];
        
        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em->flush();
                $event = new UserChangeLanguageEvent($user);
                $this->get('event_dispatcher')->dispatch(ABOMatejerEvents::USER_CHANGE_LANGUAGE, $event);
                $this->get('fos_http_cache.handler.tag_handler')
                    ->invalidateTags(array('usr-nav-' . $user->getId()));
                $html = $this->render('FOSUserBundle:Profile:editViewRender.html.twig', array(
                    'user' => $user,
                    'type' => 'general',
                ))->getContent();
                $injectIn = '#general_view_container';
                $response['stat'] = 'form_submit_success';
            }
        }
        if(empty($html)) {
            $html = $this->render('FOSUserBundle:Profile:editFormRender.html.twig', array(
                'form' => $form->createView(),
                'type' => 'general',
            ))->getContent();
            $injectIn = '#general_form_container';
        }
        $response['injections'] = array([
                    'action' => 'html',
                    'injectIn' => $injectIn,
                    'content' => html_entity_decode($html),
                ],);
        
        return new JsonResponse($response);
    }
    
    /**
     * @Route("/edit/address", name="abo_user_profile_addressform", methods={"POST"})
     */
    public function addressFormAction(Request $request) {
        
        $user = $this->getUser();
        
        $address = $user->getAddress();
        $em = $this->getDoctrine()->getManager();
        
        $form = $this->createForm( UserAddressType::class, $user, array(
            'action' => $this->generateUrl('abo_user_profile_addressform'),
        ));
        $response = ['stat'=>''];
        
        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em->flush();
                $html = $this->render('FOSUserBundle:Profile:editViewRender.html.twig', array(
                    'address' => $address,
                    'type' => 'address',
                ))->getContent();
                $injectIn = '#address_view_container';
                $response['stat'] = 'form_submit_success';
            }
        }
        
        if(empty($html)){
            $html = $this->render('FOSUserBundle:Profile:editFormRender.html.twig', array(
                'form' => $form->createView(),
                'type' => 'address',
            ))->getContent();
            $injectIn = '#address_form_container';
        }
        $response['injections'] = array([
                    'action' => 'html',
                    'injectIn' => $injectIn,
                    'content' => html_entity_decode($html),
                ],);
        
        return new JsonResponse($response);
    }
    
    /**
     * @Route("/edit/contact", name="abo_user_profile_contactform", methods={"POST"})
     */
    public function contactFormAction(Request $request) {
        
        $user = $this->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $phones = $em->getRepository('ABOMainBundle:PhoneUser')->getPhones($user);
        
        $form = $this->createForm( UserPhoneType::class, null, array(
            'action' => $this->generateUrl('abo_user_profile_contactform'),
            'phones' => $phones,
        ));
        $response = ['stat'=>''];
        
        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if($form->isValid()){
                $phEm = $this->get('abo.phonemail');
                $phones = $phEm->submitPhone($form, $phones, $user);
                if ($form->isValid()) {
                    $em->flush();
                    $html = $this->render('FOSUserBundle:Profile:editViewRender.html.twig', array(
                        'phones' => $phones,
                        'user' => $user,
                        'type' => 'contact',
                    ))->getContent();
                    $injectIn = '#contact_view_container';
                    $response['stat'] = 'form_submit_success';
                }
            }
        }
        if(empty($html)){
            $html = $this->render('FOSUserBundle:Profile:editFormRender.html.twig', array(
                'form' => $form->createView(),
                'type' => 'contact',
            ))->getContent();
            $injectIn = '#contact_form_container';
        }
        $response['injections'] = array([
                    'action' => 'html',
                    'injectIn' => $injectIn,
                    'content' => html_entity_decode($html),
                ],);
        
        return new JsonResponse($response);
    }
}
