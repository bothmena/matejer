<?php

namespace ABO\UserBundle\Controller;

use ABO\MainBundle\Entity\Category;
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
class ProductController extends Controller {

    /**
     * @Route("/liked-products/{page}", requirements={"page" = "\d+"}, defaults={"page" = 1})
     */
    public function likedAction(Request $request, $page) {

        $user = $this->getUser();
        $query = $this->getDoctrine()->getRepository('ABOMainBundle:Wishlist')->getAllProducts($user);

        $wishlist = $this->get('knp_paginator')->paginate( $query, $request->query->getInt('page', $page), 15);
        if(empty($wishlist->getItems()) && $page > 1)
            throw $this->createNotFoundException($this->get('translator')->trans('not_found.page'));

        return $this->render('ABOUserBundle:Product:favored.html.twig', array(
            'user' => $user,
            'wishlist' => $wishlist,
        ));
    }

    /**
     * @Route("/liked-products/{slug}/{page}", requirements={"page" = "\d+"}, defaults={"page" = 1})
     */
    public function likedByCatAction(Request $request, Category $category, $page) {

        $user = $this->getUser();
        $query = $this->getDoctrine()->getRepository('ABOMainBundle:Wishlist')->getProdByCategory($user, $category);
        $wishlist = $this->get('knp_paginator')->paginate( $query, $request->query->getInt('page', $page), 15);
        if(empty($wishlist->getItems()) && $page > 1)
            throw $this->createNotFoundException($this->get('translator')->trans('not_found.page'));

        return $this->render('ABOUserBundle:Product:prodByCategory.html.twig', array(
            'user' => $user,
            'transCat' => $category->getTranslatable(),
            'wishlist' => $wishlist,
        ));
    }

    /**
     * @Route("/reviews/products/{page}", requirements={"page" = "\d+"}, defaults={"page" = 1})
     */
    public function reviewsAction(Request $request, $page) {

        $user = $this->getUser();
        $query = $this->getDoctrine()->getRepository('ABOMainBundle:RatingProduct')->userReviews($user);

        $reviews = $this->get('knp_paginator')->paginate( $query, $request->query->getInt('page', $page), 12);
        if(empty($reviews->getItems()) && $page > 1)
            throw $this->createNotFoundException($this->get('translator')->trans('not_found.page'));

        return $this->render('ABOUserBundle:Product:reviews.html.twig', array(
            'user' => $user,
            'reviews' => $reviews,
        ));
    }
}
