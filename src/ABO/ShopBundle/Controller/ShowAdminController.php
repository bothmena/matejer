<?php

namespace ABO\ShopBundle\Controller;

use ABO\ShopBundle\Entity\Shop;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\HttpCacheBundle\Configuration\Tag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Cache(public=false, maxage="0", smaxage="0")
 * @Security("is_granted('ROLE_TAJER')")
 * @Route("/myShop", methods={"GET"}, host="seller.matejer.local")
 */
class ShowAdminController extends Controller {

    /**
     * @Route("/nav/{_locale}/{id}", methods={"POST"})
     * @Cache(public=true, maxage="14400", smaxage="14400")
     * @Tag(expression="'sh-nav-' ~ shop.getId()")
     */
    public function navigationAdminAction(Shop $shop) {

        $collections = $this->getDoctrine()->getRepository('ABOShopBundle:Collection')->getNavCollection($shop);
        $categories = $this->getDoctrine()->getRepository('ABOShopBundle:CategoryShop')->getCategories($shop);
        $catService = $this->get('abo.category');
        $cats = $catService->catsToArray($categories);
        $cols = $catService->colsToArray($collections);
        
        return $this->render('ABOShopBundle::navigationAdmin.html.twig', array(
            'collections' => $cols,
            'categories' => $cats,
            'shop' => $shop,
        ));
    }
    
    /**
     * @Route("", name="abo_shop_show_homeadmin")
     */
    public function homeAdminAction() {

        $shop = $this->getUser()->getMyShop();
        $categoriesNb = $this->getDoctrine()->getRepository('ABOShopBundle:CategoryShop')->shopCategoriesNb($shop);
        $products = $this->getDoctrine()->getRepository('ABOMainBundle:ProductShop')->getLastPS($shop,5);
        $followers = $this->getDoctrine()->getRepository('ABOShopBundle:ShopUser')->getLastFollowers($shop,5);
        $reviews = $this->getDoctrine()->getRepository('ABOMainBundle:RatingShop')->getLastReviews($shop,5);

        return $this->render('ABOShopBundle:Show:homeAdmin.html.twig', array(
            'shop' => $shop,
            'products' => $products,
            'categoriesNb' => $categoriesNb,
            'followers' => $followers,
            'reviews' => $reviews,
        ));
    }

    /**
     * @Route("/subscribers/{page}", requirements={"page" = "\d+"}, defaults={"page" = 1}, name="abo_shop_show_followersadmin")
     */
    public function followersAdminAction(Request $request, $page) {

        $shop = $this->getUser()->getMyShop();
        $this->get('fos_http_cache.handler.tag_handler')->addTags([
            'flws-'. $shop->getId()
        ]);
        $query = $this->getDoctrine()->getRepository('ABOShopBundle:ShopUser')->getUsers($shop);
        $followers = $this->get('knp_paginator')->paginate( $query, $request->query->getInt('page', $page), 30);
        if(empty($followers->getItems()) && $page > 1)
            throw $this->createNotFoundException($this->get('translator')->trans('not_found.page'));

        return $this->render('ABOShopBundle:Show:followersAdmin.html.twig', array(
            'shop' => $shop,
            'followers' => $followers,
        ));
    }

    /**
     * @Route("/reviews/{page}", requirements={"page" = "\d+"}, defaults={"page" = 1}, name="abo_shop_show_reviewsadmin")
     */
    public function reviewsAdminAction(Request $request, $page) {

        $shop = $this->getUser()->getMyShop();
        $this->get('fos_http_cache.handler.tag_handler')->addTags([
            'sh-rvs-'. $shop->getId()
        ]);
        $query = $this->getDoctrine()->getRepository('ABOMainBundle:RatingShop')->getShopReviews($shop);

        $reviews = $this->get('knp_paginator')->paginate( $query, $request->query->getInt('page', $page), 30);
        if(empty($reviews->getItems()) && $page > 1)
            throw $this->createNotFoundException($this->get('translator')->trans('not_found.page'));

        return $this->render('ABOShopBundle:Show:reviewsAdmin.html.twig', array(
            'shop' => $shop,
            'reviews' => $reviews,
        ));
    }

    /**
     * @Route("/about", name="abo_shop_show_aboutadmin")
     */
    public function aboutAdminAction() {

        $shop = $this->getUser()->getMyShop();
        $this->get('fos_http_cache.handler.tag_handler')->addTags([
            'sh-ab-'. $shop->getId()
        ]);
        $shop = $this->getDoctrine()->getRepository('ABOShopBundle:Shop')
            ->getShopWithAddress($this->getUser()->getMyShop()->getSlug());
        $this->get('fos_http_cache.handler.tag_handler')
            ->addTags(['myshop-about', 'myshop-about-' . $shop->getSlug() ]);

        return $this->render('ABOShopBundle:Show:aboutAdmin.html.twig', array(
            'shop' => $shop,
        ));
    }
}
