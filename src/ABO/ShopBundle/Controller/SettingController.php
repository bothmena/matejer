<?php

namespace ABO\ShopBundle\Controller;

use ABO\MainBundle\Form\PasswordType;
use ABO\ShopBundle\Form\CollectionType;
use ABO\ShopBundle\Form\PaymentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("is_granted('ROLE_TAJER')")
 * @Route("/myShop", host="seller.matejer.local")
 * @Cache(public=false, maxage="0", smaxage="0")
 */
class SettingController extends Controller {
    
    /**
     * @Route("/categories/remove/{id}", name="abo_shop_admin_removecategory", methods={"POST"})
     */
    public function removeCategoryAction($id) {

        $user = $this->getUser();
        $translator = $this->get('translator');
        $em = $this->getDoctrine()->getManager();
        $shop = $user->getMyShop();
        $catS = $em->getRepository('ABOShopBundle:CategoryShop')->findOneBy(array('shop'=>$shop,'id'=>$id));
        if(!$catS){
            return new JsonResponse(array(
                'stat'=>'danger',
                'title' => $translator->trans('category_setting_page.error_title'),
                'content'=>  $translator->trans('category_setting_page.cat_shop_unfound'),
            ));
        }
        $em->remove($catS);
        $em->flush();
        $this->get('fos_http_cache.handler.tag_handler')
            ->invalidateTags(array('sh-nav-' . $shop->getId(),'sh-ctof-' . $shop->getId()));
        $this->get('fos_http_cache.cache_manager')
            ->invalidateRoute('shop_parts_catsnb', array('slug'=>$shop->getSlug()));
        return new JsonResponse(array(
            'stat'=>'success',
            'form_stat'=>'success','content'=>  '',
            'title' => $translator->trans('category_setting_page.success_title'),
        ));
    }

    /**
     * @Route("/password-unlock", methods={"GET","POST"}, name="abo_shop_admin_passwordunlock")
     */
    public function passwordUnlockAction(Request $request) {

        $user = $this->getUser();
        $form = $this->createForm(PasswordType::class, $user, array(
            'action' => $this->generateUrl('abo_shop_admin_passwordunlock'),
        ));
        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                return new JsonResponse(['stat'=>'success', 'form_stat'=>'success']);
            }
        }

        $html = $this->render('ABOShopBundle:Admin:passwordUnlock.html.twig', array(
            'type' => 'category',
            'message'=>'matejer_main.pass_unlock_shop',
            'form' => $form->createView(),
        ))->getContent();
        return new JsonResponse(array(
            'stat'=>'success',
            'form_stat'=>'error',
            'template' => html_entity_decode($html),
        ));
    }
    
    /**
     * @Route("/collections/remove/{id}", name="abo_shop_admin_collectionremove", methods={"POST"})
     */
    public function collectionRemoveAction($id) {

        $user = $this->getUser();
        $translator = $this->get('translator');
        $em = $this->getDoctrine()->getManager();
        $collection = $em->getRepository('ABOShopBundle:Collection')->findOneBy(array('shop'=>$user->getMyShop(),'id'=>$id));
        if(!$collection){
            return new JsonResponse(array(
                'stat'=>'danger',
                'title' => $translator->trans('matejer_collection.unfound_title'),
                'content'=>  $translator->trans('matejer_collection.unfound_content'),
            ));
        }
        $colP = $em->getRepository('ABOShopBundle:CollectionProduct')->findByCollection($collection);
        foreach ($colP as $value) {
            $em->remove($value);
        }
        $em->remove($collection);
        $em->flush();
        $shop = $user->getMyShop();
        
        $this->get('fos_http_cache.handler.tag_handler')
            ->invalidateTags(array('sh-nav-' . $shop->getId(),'oibs-' . $shop->getId()));
        return new JsonResponse(array(
            'stat'=>'success',
            'title' => $this->get('translator')->trans('matejer_collection.removed_title'),
            'content' => $this->get('translator')->trans('matejer_collection.removed_content'),
        ));
    }
    
    /**
     * @Route("/collections/edit/{id}", name="abo_shop_admin_collectionedit", methods={"GET", "POST"})
     */
    public function collectionEditAction(Request $request, $id) {

        $translator = $this->get('translator');
        $shop = $this->getUser()->getMyShop();
        $em = $this->getDoctrine()->getManager();
        $collection = $em->getRepository('ABOShopBundle:Collection')->findOneBy(array('shop'=>$shop, 'id'=>$id));
        if(!$collection){
            return new JsonResponse(array(
                'stat'=>'danger',
                'title' => $translator->trans('matejer_collection.unfound_title'),
                'content'=>  $translator->trans('matejer_collection.unfound_content'),
            ));
        }
        $cats = $em->getRepository('ABOShopBundle:CategoryShop')->getCategories($shop);
        $categoriesIds = array();
        foreach ($cats as $value){
            array_push ($categoriesIds, $value->getCategory()->getId()); }

        $form = $this->createForm( CollectionType::class, $collection, array(
            'action' => $this->generateUrl('abo_shop_admin_collectionedit', array('id'=>$id)),
            'categoriesId' => $categoriesIds,
            'shop' => $shop,
        ));
        
        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            $parent = $form->get('parent')->getData();
            if($parent && ( ( $form->get('anyParent')->getData() && $parent->getLevel() > 1 ) || $parent->getLevel() > 2)){
                $error = new FormError($this->get('translator')->trans('collection.isparent.level_3', [], 'validators'));
                $form->get('anyParent')->addError($error);
            }
            if ($form->isValid()) {
                if($parent)
                    $collection->setLevel($parent->getLevel() + 1);
                else
                    $collection->setLevel( 1 );
                $em->flush();
                $this->get('fos_http_cache.handler.tag_handler')
                    ->invalidateTags(array('sh-nav-' . $shop->getId(),'oibs-' . $shop->getId()));
                return new JsonResponse(array(
                    'form_stat'=>'success',
                    'title' => $translator->trans('matejer_collection.success_title'),
                    'content'=>  $translator->trans('matejer_collection.success_content'),
                    'data' => $collection->getName(),
                ));
            }
        }
        
        $html = $this->render('ABOShopBundle:Admin:collectionForm.html.twig', array(
            'form' => $form->createView(),
        ))->getContent();
        return new JsonResponse(array(
            'stat'=>'success', 
            'form_stat'=>'error',
            'template' => html_entity_decode($html),
        ));
    }
    
    /**
     * @Route("/payments/edit/{id}", name="abo_shop_admin_paymentedit", methods={"GET", "POST"})
     */
    public function paymentEditAction(Request $request, $id) {

        $user = $this->getUser();
        $translator = $this->get('translator');
        $em = $this->getDoctrine()->getManager();
        $payment = $em->getRepository('ABOShopBundle:Payment')->findOneBy(array('shop'=>$user->getMyShop(), 'id'=>$id));
        if(!$payment){
            return new JsonResponse(array(
                'stat'=>'danger',
                'title' => $translator->trans('matejer_payment.unfound_title'),
                'content'=>  $translator->trans('matejer_payment.unfound_content'),
            ));
        }

        $form = $this->createForm(PaymentType::class , $payment, array(
            'action'=>$this->generateUrl('abo_shop_admin_paymentedit', array('id'=>$id)),
        ));
        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em->flush();
                $this->get('fos_http_cache.handler.tag_handler')
                    ->invalidateTags(['mofs-' . $user->getMyShop()->getId(), 'oibs-' . $user->getMyShop()->getId()]);
                return new JsonResponse(array(
                    'form_stat'=>'success',
                    'title' => $translator->trans('matejer_payment.success_title'),
                    'content'=>  $translator->trans('matejer_payment.success_content'),
                    'data' => $payment->getDescription().' '.$translator->trans('matejer_payment.month'),
                ));
            }
        }
        
        $html = $this->render('ABOShopBundle:Admin:paymentForm.html.twig', array(
            'form' => $form->createView(),
        ))->getContent();
        return new JsonResponse(array(
            'stat'=>'success', 
            'form_stat'=>'error',
            'template' => html_entity_decode($html),
        ));
    }
    
    /**
     * @Route("/payments/remove/{id}", name="abo_shop_admin_paymentremove", methods={"POST"})
     */
    public function paymentRemoveAction($id) {

        $shop = $this->getUser()->getMyShop();
        $translator = $this->get('translator');
        $em = $this->getDoctrine()->getManager();
        $payment = $em->getRepository('ABOShopBundle:Payment')->findOneBy(array('shop'=>$shop,'id'=>$id));
        if(!$payment){
            return new JsonResponse(array(
                'stat'=>'danger',
                'title' => $translator->trans('matejer_payment.unfound_title'),
                'content'=>  $translator->trans('matejer_payment.unfound_content'),
            ));
        }
        $payP = $em->getRepository('ABOShopBundle:PaymentProduct')->findByPayment($payment);
        foreach ($payP as $value) {
            $em->remove($value);  }
        $em->remove($payment);
        $em->flush();
        $this->get('fos_http_cache.handler.tag_handler')
            ->invalidateTags(['mofs-' . $shop->getId(), 'oibs-' . $shop->getId()]);
        return new JsonResponse(array(
            'stat'=>'success',
            'form_stat'=>'success',
            'title' => $this->get('translator')->trans('matejer_payment.removed_title'),
            'content' => $this->get('translator')->trans('matejer_payment.removed_content'),
        ));
    }
}
