<?php

namespace ABO\ShopBundle\Controller;

use ABO\MainBundle\Entity\EmailShop;
use ABO\MainBundle\Form\CategoryType;
use ABO\ShopBundle\Entity\Collection;
use ABO\ShopBundle\Entity\Payment;
use ABO\ShopBundle\Form\CollectionType;
use ABO\ShopBundle\Form\ConfirmEmailType;
use ABO\ShopBundle\Form\PaymentType;
use ABO\ShopBundle\Form\ShopAddressType;
use ABO\ShopBundle\Form\ShopContactType;
use ABO\ShopBundle\Form\ShopPersonalType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("is_granted('ROLE_TAJER')")
 * @Route("/myShop", methods={"GET"}, host="seller.matejer.local")
 * @Cache(public=false, maxage="0", smaxage="0")
 */
class AdminController extends Controller {
    
    /**
     * @Route("/edit")
     */
    public function settingAction() {

        $shop = $this->getUser()->getMyShop();
        $em = $this->getDoctrine()->getManager();
        $phones = $em->getRepository('ABOMainBundle:PhoneShop')->getPhones($shop);
        $emails = $em->getRepository('ABOMainBundle:EmailShop')->getEmails($shop);
        $categoriesNb = $this->getDoctrine()->getRepository('ABOShopBundle:CategoryShop')->shopCategoriesNb($shop);
        $productNb = $this->getDoctrine()->getRepository('ABOMainBundle:ProductShop')->getPSNb($shop);

        return $this->render('ABOShopBundle:Admin:setting.html.twig', array(
            'shop' => $shop,
            'emails' => $emails,
            'phones' => $phones,
            'categoriesNb' => $categoriesNb,
            'productNb' => $productNb,
        ));
    }
    
    /**
     * @Route("/edit/general", methods={"POST"})
     */
    public function generalFormAction(Request $request) {
        
        $shop = $this->getUser()->getMyShop();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(ShopPersonalType::class, $shop,
                array( 'action' => $this->generateUrl('abo_shop_admin_generalform')));
        $response = ['stat'=>''];
        
        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em->flush();
                $this->get('fos_http_cache.handler.tag_handler')
                    ->invalidateTags(array(
                        'card-shop-' . $shop->getId(),
                        'mdl-shop-' . $shop->getId(),
                        'sh-info-' . $shop->getId(),
                    ));
                $this->get('fos_http_cache.cache_manager')
                    ->invalidateRoute('shop_parts_shopname', array('slug'=>$shop->getSlug()));
                $html = $this->render('ABOShopBundle:Admin:editViewRender.html.twig', array(
                    'shop' => $shop,
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
     * @Route("/edit/address", methods={"POST"})
     */
    public function addressFormAction(Request $request) {
        
        $shop = $this->getUser()->getMyShop();
        $em = $this->getDoctrine()->getManager();
        
        $form = $this->createForm( ShopAddressType::class, $shop,  array(
            'action' => $this->generateUrl('abo_shop_admin_addressform'),
        ));

        $response = ['stat'=>''];
        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em->flush();
                $this->get('fos_http_cache.handler.tag_handler')
                    ->invalidateTags(array('sh-cont-' . $shop->getId()));
                $html = $this->render('ABOShopBundle:Admin:editViewRender.html.twig', array(
                    'shop' => $shop,
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
     * @Route("/edit/contact", methods={"POST"})
     */
    public function contactFormAction(Request $request) {
        
        $shop = $this->getUser()->getMyShop();
        $em = $this->getDoctrine()->getManager();
        $phones = $em->getRepository('ABOMainBundle:PhoneShop')->getPhones($shop);
        $emails = $em->getRepository('ABOMainBundle:EmailShop')->getEmails($shop);
        
        $form = $this->createForm( ShopContactType::class, $shop, array(
            'action' => $this->generateUrl('abo_shop_admin_contactform'),
            'phones' => $phones,
            'emails' => $emails,
        ));

        $response = ['stat'=>''];
        if ($request->getMethod() === 'POST') {
            
            $form->handleRequest($request);
            if($form->isValid()){
                $phEm = $this->get('abo.phonemail');
                $result = $phEm->submitPhoneEmail($form, $phones, $emails, $shop);

                if ($form->isValid()) {
                    $this->get('fos_http_cache.handler.tag_handler')
                        ->invalidateTags(array('sh-cont-' . $shop->getId()));
                    foreach ($result['emails'] as $email) {
                        $this->sendCodeEmail($email);
                    }
                    $html = $this->render('ABOShopBundle:Admin:editViewRender.html.twig', array(
                        'phones' => $result['phones'],
                        'emails' => $result['emails'],
                        'shop' => $shop,
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
    
    private function sendCodeEmail(EmailShop $emailShop) {
        if( !empty($emailShop->getCode()) ){
            $mailer = $this->get('abo.mail');
            $mailer->shopConfirmation($this->getUser(), $emailShop);
        }
    }
    
    /**
     * @Route("/edit/send-code/{id}", methods={"POST"})
     */
    public function sendCodeAction($id) {
        
        $emailShop = $this->getDoctrine()->getRepository('ABOMainBundle:EmailShop')->find($id);
        $translator = $this->get('translator');
        if($emailShop){
            $this->sendCodeEmail ($emailShop);
            return new JsonResponse(array(
                'stat'=>'success',
                'title' => $translator->trans('matejer_email.code_sent'),
                'content'=>  $translator->trans('matejer_email.code_sent_content'),
            ));
        }
        else
            return new JsonResponse(array(
                'stat'=>'danger',
                'title' => $translator->trans('matejer_email.email_unfound_title'),
                'content'=>  $translator->trans('matejer_email.email_unfound'),
            ));
    }
    
    /**
     * @Route("/edit/confirm-email/{id}", methods={"POST"}, requirements={"id" = "\d+"})
     */
    public function confirmEmailAction(Request $request, $id) {

        $form = $this->createForm(ConfirmEmailType::class);
        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $translator = $this->get('translator');
                $emailShop = $em->getRepository('ABOMainBundle:EmailShop')->find($id);
                if($emailShop){
                    if($form->get('code')->getData() === $emailShop->getCode()){
                        $emailShop->confirm();
                        $em->flush();
                        $this->get('fos_http_cache.handler.tag_handler')
                            ->invalidateTags(array('sh-cont-' . $shop->getId()));
                        return new JsonResponse(array(
                            'stat'=>'success',
                            'title' => $translator->trans('matejer_email.confirm_title'),
                            'content'=>  $translator->trans('matejer_email.confirm_success'),
                        ));
                    }else{
                        return new JsonResponse(array(
                            'stat'=>'error',
                            'content'=>  $translator->trans('matejer_email.confirm_error'),
                        ));
                    }
                }else{
                    return new JsonResponse(array(
                        'stat'=>'error',
                        'content'=>  $translator->trans('matejer_email.email_unfound'),
                    ));
                }
            }
        }
        return $this->render('ABOShopBundle:Admin:confirmEmail.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/categories", methods={"POST"})
     */
    public function setCategoriesAction(Request $request) {

        $shop = $this->getUser()->getMyShop();
        $catService = $this->get('abo.category');
        $form = $this->createForm( CategoryType::class, null, array(
            'action' => $this->generateUrl('abo_shop_admin_setcategories'),
            'categories' => $catService->getCats(),
        ));
        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                
                $this->get('fos_http_cache.handler.tag_handler')
                    ->invalidateTags(array('sh-nav-' . $shop->getId(), 'sh-ctof-' . $shop->getId()));
                $this->get('fos_http_cache.cache_manager')
                    ->invalidateRoute('shop_parts_catsnb', array('slug'=>$shop->getSlug()));
                $catService->shop($form, $shop);
                return $this->redirect($this->generateUrl('abo_shop_show_homeadmin'));
            }
        }
        $shopCategories = $this->getDoctrine()->getRepository('ABOShopBundle:CategoryShop')
            ->getCategories($shop);
        
        return $this->render('ABOShopBundle:Admin:setCategories.html.twig', array(
            'shop' => $shop,
            'form' => $form->createView(),
            'shopCategories' => $shopCategories,
        ));
    }
    
    /**
     * @Route("/collections", methods={"POST"})
     */
    public function collectionsAction(Request $request) {

        $shop = $this->getUser()->getMyShop();
        $shopCollections = $this->getDoctrine()->getRepository('ABOShopBundle:Collection')
            ->findBy((array('shop'=>$shop)));

        $cats = $this->getDoctrine()->getRepository('ABOShopBundle:CategoryShop')->getCategories($shop);
        $categoriesIds = array();
        foreach ($cats as $value)
            array_push ($categoriesIds, $value->getCategory()->getId());

        $collection = new Collection;
        $form = $this->createForm( CollectionType::class, $collection, array(
            'categoriesId' => $categoriesIds,
            'shop' => $shop,
            'action' => $this->generateUrl('abo_shop_admin_collections'),
        ));
        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            $parent = $form->get('parent')->getData();
            if($parent && ( ( $form->get('anyParent')->getData() && $parent->getLevel() > 1 ) || $parent->getLevel() > 2)){
                $error = new FormError($this->get('translator')->trans('collection.isparent.level_3', [], 'validators'));
                $form->get('anyParent')->addError($error);
            }

            if ($form->isValid()) {
                $collection->setShop($shop);
                $em = $this->getDoctrine()->getManager();
                $em->persist($collection);
                $em->flush();
                $this->get('fos_http_cache.handler.tag_handler')
                    ->invalidateTags(array('sh-nav-' . $shop->getId()));
                return $this->redirect($this->generateUrl('abo_shop_admin_collections'));
            }
        }
        
        return $this->render('ABOShopBundle:Admin:collections.html.twig', array(
            'shop' => $shop,
            'form' => $form->createView(),
            'shopCollections' => $shopCollections,
        ));
    }

    /**
     * @Route("/payments", methods={"POST"})
     */
    public function paymentsAction(Request $request) {
        
        $user = $this->getUser();
        $shop = $user->getMyShop();
        if(!$shop)
            throw $this->createNotFoundException ('we couldn\'t find the shop');
        $shopPayments = $this->getDoctrine()->getRepository('ABOShopBundle:Payment')
            ->findBy((array('shop'=>$shop)));

        $payment = new Payment;
        $form = $this->createForm(PaymentType::class, $payment, array(
            'action' => $this->generateUrl('abo_shop_admin_payments'),
        ));
        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $payment->setShop($shop);
                $em = $this->getDoctrine()->getManager();
                $em->persist($payment);
                $em->flush();
                return $this->redirect($this->generateUrl('abo_shop_admin_payments'));
            }
        }
        
        return $this->render('ABOShopBundle:Admin:payments.html.twig', array(
            'shop' => $shop,
            'form' => $form->createView(),
            'shopPayments' => $shopPayments,
            'admin' => true,
        ));
    }
}
