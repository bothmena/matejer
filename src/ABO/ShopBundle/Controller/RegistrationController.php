<?php

namespace ABO\ShopBundle\Controller;

use ABO\MainBundle\Entity\Address;
use ABO\MainBundle\Entity\EmailShop;
use ABO\MainBundle\Event\ShopNewEmailEvent;
use ABO\MainBundle\Event\ShopRegistrationSuccessEvent;
use ABO\ShopBundle\Entity\Shop;
use ABO\ShopBundle\Form\ShopType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends Controller {
    
    /**
     * @Route("/register", methods={"GET", "POST"}, host="seller.matejer.local")
     * @Security("is_granted('ROLE_USER')")
     * @Cache(public=false, maxage=0, smaxage=0)
     */
    public function registerAction(Request $request) {
        
        $user = $this->getUser();
        $translator = $this->get('translator');
        if(!empty($user->getMyShop()))
            throw $this->createAccessDeniedException($translator->trans('access_denied.has_shop'));
        if($user->getNewEmail() === '' && $user->getConfirmationToken() !== null)
            throw $this->createAccessDeniedException($translator->trans('access_denied.email_unconfirmed'));

        $em = $this->getDoctrine()->getManager();
        $shop = new Shop();
        $form = $this->createForm( ShopType::class, $shop, array(
            'action' => $this->generateUrl('abo_shop_registration_register'),
        ));

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);

            $email = $form->get('email')->get('email')->getData();
            $emailS = $this->getDoctrine()->getRepository('ABOMainBundle:EmailShop')->findOneBy(array('email' => $email));
            if($emailS)
                $form->get('email')->get('email')->addError(new FormError($translator->trans('email_shop.email.unique', [], 'validators')));

            if ($form->isValid()) {
                
                $user->setMyshop($shop);
                $user->addRole('ROLE_TAJER');
                $dispatcher = $this->get('event_dispatcher');
                $image = $em->getRepository('ABOMainBundle:Image')->find(3);
                $cover = $em->getRepository('ABOMainBundle:Image')->find(4);
                $shop->setImage($image);
                $shop->setCover($cover);
                
                $email = new EmailShop();
                $email->setEmail($form->get('email')->getData()->getEmail());
                $emailEvent = new ShopNewEmailEvent($user, $email, $shop);
                $dispatcher->dispatch('abo.shop_new_email', $emailEvent);
                
                $shopEvenet = new ShopRegistrationSuccessEvent($user, $shop, $email);
                $dispatcher->dispatch('abo.shop_registration_success', $shopEvenet);
                $em->persist($email);
                $em->persist($shop);
                $em->flush();
                return $this->redirect($this->generateUrl('abo_user_security_logout'));
            }
        }

        $html = $this->render('ABOShopBundle:Registration:register.html.twig', array(
            'form' => $form->createView(),
        ));
        if(in_array('text/html', $request->getAcceptableContentTypes()))
            return $html;

        $response['injections'] = array([
            'action' => 'html',
            'content' => html_entity_decode($html->getContent()),
        ],);
        return new JsonResponse($response);
    }
}
