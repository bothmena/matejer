<?php

namespace ABO\ShopBundle\Controller;

use ABO\MainBundle\Entity\RatingShop;
use ABO\ShopBundle\Entity\Shop;
use FOS\HttpCacheBundle\Configuration\Tag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Cache(public=true, maxage="14400", smaxage="14400")
 * @Route("/{slug}", methods={"GET"}, host="matejer.local")
 */
class ShowController extends Controller {

    /**
     * @Route("/{_locale}/nav", methods={"POST"})
     * @Tag(expression="'sh-nav-' ~ shop.getId()")
     */
    public function navigationAction(Shop $shop) {

        $collections = $this->getDoctrine()->getRepository('ABOShopBundle:Collection')->getNavCollection($shop);
        $categories = $this->getDoctrine()->getRepository('ABOShopBundle:CategoryShop')->getCategories($shop);
        $catService = $this->get('abo.category');
        $cats = $catService->catsToArray($categories);
        $cols = $catService->colsToArray($collections);
        
        return $this->render('ABOShopBundle::navigation.html.twig', array(
            'collections' => $cols,
            'categories' => $cats,
            'shop' => $shop,
        ));
    }

    /**
     * @Route("")
     * @Cache(public=false, maxage="0", smaxage="0")
     * @ParamConverter("shop", class="ABOShopBundle:Shop", options={
     *    "repository_method" = "getShopCoverAddress",
     *    "map_method_signature" = true
     * })
     */
    public function homeAction(Shop $shop) {

        if($this->get('security.authorization_checker')->isGranted('ROLE_TAJER') && $this->getUser()->getMyShop() === $shop)
            return $this->redirectToRoute('abo_shop_show_homeadmin');

        return $this->render('ABOShopBundle:Show:home.html.twig', array(
            'shop' => $shop,
        ));
    }

    /**
     * @Route("/reviews/{page}", requirements={"page" = "\d+"}, defaults={"page" = 1})
     * @Cache(public=false, maxage="0", smaxage="0")
     * @ParamConverter("shop", class="ABOShopBundle:Shop", options={
     *    "repository_method" = "getShopWithAddress",
     *    "map_method_signature" = true
     * })
     */
    public function reviewsAction(Request $request, Shop $shop, $page) {

        if($this->get('security.authorization_checker')->isGranted('ROLE_TAJER') && $this->getUser()->getMyShop() === $shop)
            return $this->redirectToRoute('abo_shop_show_reviewsadmin');

        $rate_repo = $this->getDoctrine()->getRepository('ABOMainBundle:RatingShop');
        $choices = array('shop' => $shop);
        $phone = $this->getDoctrine()->getRepository('ABOMainBundle:PhoneShop')->findOneBy(['shop'=>$shop]);
        $email = $this->getDoctrine()->getRepository('ABOMainBundle:EmailShop')->findOneBy(['shop'=>$shop]);
        
        if($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')){
            
            $userReview = $rate_repo->getUserShopReview($shop,$this->getUser());
            $query = $rate_repo->getShopReviewsUser($shop,$this->getUser());
            $choices['userReview'] = $userReview;
        }else
            $query = $rate_repo->getShopReviews($shop);

        $reviews = $this->get('knp_paginator')->paginate( $query, $request->query->getInt('page', $page), 30);
        if(empty($reviews->getItems()) && $page > 1)
            throw $this->createNotFoundException($this->get('translator')->trans('not_found.page'));

        $choices['reviews'] = $reviews;
        $choices['phone'] = empty($phone)? '':$phone->getFull();
        $choices['email'] = empty($email)? '':$email->getEmail();
        
        return $this->render('ABOShopBundle:Show:reviews.html.twig', $choices);
    }

    /**
     * @Route("/user-review-rs", name="shop_show_userreviewrs")
     * @Cache(public=false, maxage=0, smaxage=0)
     */
    public function userReviewRSAction(Shop $shop, $isNew = false) {

        if ($this->get('security.authorization_checker')->isGranted('ROLE_USER'))
            $userReview = $this->getDoctrine()->getRepository('ABOMainBundle:RatingShop')
                ->findOneBy(array('user'=>$this->getUser(), 'shop'=>$shop));

        $id = $isNew || empty($userReview) ? 0 : $userReview->getId();

        return $this->render('@ABOShop/Show/userReviewRS.html.twig', array(
            'shop'=>$shop,
            'userReview' => empty($userReview) ? null : $userReview,
            'id' => $id,
        ));
    }

    /**
     * @Route("/about")
     * @Cache(public=false, maxage="0", smaxage="0")
     * @ParamConverter("shop", class="ABOShopBundle:Shop", options={
     *    "repository_method" = "getShopWithAddress",
     *    "map_method_signature" = true
     * })
     */
    public function aboutAction(Shop $shop) {

        if($this->get('security.authorization_checker')->isGranted('ROLE_TAJER') && $this->getUser()->getMyShop() === $shop)
            return $this->redirectToRoute('abo_shop_show_aboutadmin');

        $phone = $this->getDoctrine()->getRepository('ABOMainBundle:PhoneShop')->findOneBy(['shop'=>$shop]);
        $email = $this->getDoctrine()->getRepository('ABOMainBundle:EmailShop')->findOneBy(['shop'=>$shop]);

        return $this->render('ABOShopBundle:Show:about.html.twig', array(
            'shop' => $shop,
            'phone' => empty($phone)? '':$phone->getFull(),
            'email' => empty($email)? '':$email->getEmail(),
        ));
    }

    /**
     * @Route("/show/{_locale}/cats-offers")
     * @Tag(expression="'sh-ctof-' ~ shop.getId()")
     */
    public function catsAndOffersAction(Shop $shop){

        $categories = $this->getDoctrine()->getRepository('ABOShopBundle:CategoryShop')->getCategories($shop);

        return $this->render('ABOShopBundle:Show:catsAndOffers.html.twig', array(
            'categories' => $categories,
        ));
    }

    /**
     * @Route("/show/{_locale}/shop-infos")
     * @Tag(expression="'sh-info-' ~ shop.getId()")
     */
    public function shopInfosAction(Shop $shop){
        return $this->render('@ABOShop/Show/shopInfos.html.twig', array(
            'shop'=>$shop,
        ));
    }

    /**
     * @Route("/show/{_locale}/shop-contact")
     * @Tag(expression="'sh-cont-' ~ shop.getId()")
     */
    public function shopContactAction(Shop $shop){

        $phones = $this->getDoctrine()->getRepository('ABOMainBundle:PhoneShop')->getPhones($shop);
        $emails = $this->getDoctrine()->getRepository('ABOMainBundle:EmailShop')->getEmails($shop);

        return $this->render('ABOShopBundle:Show:shopContact.html.twig', array(
            'shop' => $shop,
            'phones' => $phones,
            'emails' => $emails,
        ));
    }

    /**
     * @Route("/show/shop_seo")
     * @Cache(public=true, maxage="86400", smaxage="86400")
     */
    public function shopSEOAction(Shop $shop){

        $phone = $this->getDoctrine()->getRepository('ABOMainBundle:PhoneShop')->findOneBy(['shop'=>$shop]);
        $email = $this->getDoctrine()->getRepository('ABOMainBundle:EmailShop')->findOneBy(['shop'=>$shop]);

        return $this->render('ABOShopBundle:Show:shopSEO.html.twig', array(
            'shop' => $shop,
            'phone' => $phone ? $phone->getFull() : '',
            'email' => $email ? $email->getEmail() : '',
        ));
    }
}
