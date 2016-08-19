<?php

namespace ABO\MainBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("", methods={"GET", "POST"}, host="matejer.local")
 * @Cache(public=false, maxage="0", smaxage="0")
 */
class GalleryController extends Controller {

    /**
     * @Route("/gallery/{search}", defaults={"search" = "no_query"})
     */
    public function galleryAction($search) {

        if($this->getUser())
            $this->getDoctrine()->getRepository('ABOUserBundle:User')->getFullUser($this->getUser()->getId());
        
        return $this->render('ABOMainBundle:Gallery:gallery.html.twig', array(
            'search' => $search,
        ));
    }

    /**
     * @Route("/gallery-product/{page}/{search}", requirements={"page" = "\d+"}, defaults={"search" = "no_query", "page" = 1})
     */
    public function galleryProductAction($search, $page, Request $request) {

        if($search === 'no_query')
            $prods_q = $this->getDoctrine()->getRepository('ABOMainBundle:CategoryProduct')->myFindAll();
        else
            $prods_q = $this->getDoctrine()->getRepository('ABOMainBundle:CategoryProduct')->searchProds($search);

        $prods = $this->get('knp_paginator')
            ->paginate($prods_q, $request->query->getInt('page', $page), 20);
        $prods->setUsedRoute('abo_main_gallery_galleryproduct');

        return $this->render('ABOMainBundle:Gallery:galleryProduct.html.twig', array(
            'prods' => $prods,
            'search' => $search,
        ));
    }

    /**
     * @Route("/gallery-shop/{page}/{search}", requirements={"page" = "\d+"}, defaults={"search" = "no_query", "page" = 1})
     */
    public function galleryShopAction($search, $page, Request $request) {
        
        if($search === 'no_query')
            $shops_q = $this->getDoctrine()->getRepository('ABOShopBundle:Shop')->myFindAll();
        else
            $shops_q = $this->getDoctrine()->getRepository('ABOShopBundle:Shop')->searchShops($search);
        
        $shops = $this->get('knp_paginator')
            ->paginate($shops_q, $request->query->getInt('page', $page), 20);
        $shops->setUsedRoute('abo_main_gallery_galleryshop');

        return $this->render('ABOMainBundle:Gallery:galleryShop.html.twig', array(
            'shops' => $shops,
            'search' => $search,
        ));
    }

    /**
     * @Route("/gallery-offer/{page}/{search}", requirements={"page" = "\d+"}, defaults={"search" = "no_query", "page" = 1})
     */
    public function galleryOfferAction($search, $page, Request $request) {
        
        if($search === 'no_query')
            $offers_q = $this->getDoctrine()->getRepository('ABOMainBundle:ProductShop')->getAllPS();
        else
            $offers_q = $this->getDoctrine()->getRepository('ABOMainBundle:ProductShop')->searchPS($search);
        
        $offers = $this->get('knp_paginator')
            ->paginate($offers_q, $request->query->getInt('page', $page), 20);
        $offers->setUsedRoute('abo_main_gallery_galleryoffer');

        return $this->render('ABOMainBundle:Gallery:galleryOffer.html.twig', array(
            'offers' => $offers,
            'search' => $search,
        ));
    }
}
