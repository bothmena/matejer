<?php

namespace ABO\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/myProfile", methods={"GET"})
 * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
 * @Cache(public=false, maxage="0", smaxage="0")
 */
class ShopController extends Controller {

    /**
     * @Route("/subscibed-shops/{page}", requirements={"page" = "\d+"}, defaults={"page" = 1})
     */
    public function subscibedAction(Request $request, $page) {

        $user = $this->getUser();
        $query = $this->getDoctrine()->getRepository('ABOShopBundle:ShopUser')->getUserShops($user);

        $shops = $this->get('knp_paginator')->paginate( $query, $request->query->getInt('page', $page), 15);
        if( empty($shops->getItems()) && $page > 1 )
            throw $this->createNotFoundException($this->get('translator')->trans('not_found.page'));

        return $this->render('ABOUserBundle:Shop:subscibed.html.twig', array(
            'user' => $user,
            'shops' => $shops,
        ));
    }

    /**
     * @Route("/reviews/shops/{page}", requirements={"page" = "\d+"}, defaults={"page" = 1})
     */
    public function reviewsAction(Request $request, $page) {

        $user = $this->getUser();
        $query = $this->getDoctrine()->getRepository('ABOMainBundle:RatingShop')->userReviews($user);

        $reviews = $this->get('knp_paginator')->paginate( $query, $request->query->getInt('page', $page), 12);
        if(empty($reviews->getItems()) && $page > 1)
            throw $this->createNotFoundException($this->get('translator')->trans('not_found.page'));

        return $this->render('ABOUserBundle:Shop:reviews.html.twig', array(
            'user' => $user,
            'reviews' => $reviews,
        ));
    }
}
