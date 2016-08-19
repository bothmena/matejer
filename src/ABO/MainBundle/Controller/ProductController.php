<?php

namespace ABO\MainBundle\Controller;

use ABO\MainBundle\Entity\CategoryProduct;
use ABO\MainBundle\Entity\Feature;
use ABO\TrademarkBundle\Entity\Trademark;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\HttpCacheBundle\Configuration\Tag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("", methods={"GET"}, host="matejer.local")
 * @Cache(public=true, maxage=3600, smaxage=3600)
 */
class ProductController extends Controller {

    /**
     * @Route("/TM/{slug}/product/{slug_prod}", name="abo_main_product_product")
     * @Cache(public=false, maxage=0, smaxage=0)
     * @ParamConverter("trademark", options={"mapping": {"slug": "slug"}})
     * @ParamConverter("catProd", class="ABOMainBundle:CategoryProduct", options={ "repository_method" = "getProductBySlug", "mapping": {"slug_prod": "slug"}, "map_method_signature" = true })
     */
    public function productAction(Trademark $trademark, CategoryProduct $catProd){

        $features = $this->getDoctrine()->getRepository('ABOMainBundle:FeatureProduct')
            ->findBy(array('categoryProduct' => $catProd));

        return $this->render('@ABOMain/Product/product.html.twig', array(
            'catProd' => $catProd,
            'features' => $features,
        ));
    }

    /**
     * @Route("/esi-{_locale}/product/description/{id}", requirements={"id" = "\d+"})
     * @Tag(expression="'prod-desc-' ~ catProd.getId()")
     */
    public function descriptionAction(CategoryProduct $catProd) {

        return $this->render('ABOMainBundle:Product:description.html.twig', array(
            'catProd' => $catProd,
        ));
    }

    /**
     * @Route("/esi-{_locale}/product/fiches/{id}", requirements={"id" = "\d+"})
     * @Tag(expression="'prod-fich-' ~ categoryProduct.getId()")
     */
    public function fichesAction(Request $request, CategoryProduct $categoryProduct) {

        $fiches = $this->getDoctrine()->getRepository('ABOMainBundle:FicheProduct')
            ->findBy(array('categoryProduct' => $categoryProduct, 'language'=>$request->getLocale()));

        if(empty($fiches)){
            $fiches = $this->getDoctrine()->getRepository('ABOMainBundle:FicheProduct')
                ->findBy(array('categoryProduct' => $categoryProduct, 'language'=>$request->getDefaultLocale()));
            $this->get('fos_http_cache.handler.tag_handler')->addTags(['prfch-' . $request->getDefaultLocale() . '-' . $categoryProduct->getId()]);
        }else
            $this->get('fos_http_cache.handler.tag_handler')->addTags(['prfch-' . $request->getLocale() . '-' . $categoryProduct->getId()]);

        return $this->render('ABOMainBundle:Product:fiches.html.twig', array(
            'fiches' => $this->get('abo.util')->ficheToArray($fiches),
        ));
    }

    /**
     * @Route("/esi-{_locale}/product/feature/{id}", requirements={"id" = "\d+"})
     * @Tag(expression="'prod-ftr-' ~ feature.getId()")
     */
    public function featureAction(Feature $feature) {

        return $this->render('ABOMainBundle:Product:feature.html.twig', array(
            'feature' => $feature,
        ));
    }

    /**
     * @Route("/product/user-review-rs/{id}", requirements={"id" = "\d+"})
     * @Cache(public=false, maxage=0, smaxage=0)
     */
    public function userReviewRSAction(CategoryProduct $catProd, $isNew = false) {

        if ($this->get('security.authorization_checker')->isGranted('ROLE_USER'))
            $userReview = $this->getDoctrine()->getRepository('ABOMainBundle:RatingProduct')
                ->findOneBy(array('user'=>$this->getUser(), 'categoryProduct'=>$catProd));
        $id = $isNew || empty($userReview) ? 0 : $userReview->getId();

        return $this->render('@ABOMain/Product/userReviewRS.html.twig', array(
            'catProd'=>$catProd,
            'userReview' => empty($userReview) ? null : $userReview,
            'id' => $id,
        ));
    }

    /**
     * @Route("/product/reviews/{id}/{page}", requirements={"id" = "\d+", "page" = "\d+"}, defaults={"page" = 1})
     * @Cache(public=false, maxage=0, smaxage=0)
     */
    public function productReviewsAction(Request $request, CategoryProduct $catProd, $page) {

        if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            $query = $this->getDoctrine()->getRepository('ABOMainBundle:RatingProduct')
                ->getProductReviewsUser($catProd, $this->getUser());
        } else{
            $query = $this->getDoctrine()->getRepository('ABOMainBundle:RatingProduct')
                ->prodReviews($catProd);
        }

        $reviews = $this->get('knp_paginator')
            ->paginate($query, $request->query->getInt('page', $page), 15);

        return $this->render('ABOMainBundle:Product:productReviews.html.twig', array(
            'reviews' => $reviews,
        ));
    }

    /**
     * @Route("/product/likes-nb/{id}", requirements={"id" = "\d+"}, name="main_product_likesnb")
     */
    public function likesNbAction(CategoryProduct $product) {
        return new Response($product->getProduct()->getFavoredNb());
    }

    /**
     * @Route("/product/rate-nb/{id}", requirements={"id" = "\d+"}, name="main_product_ratenb")
     */
    public function rateNbAction(CategoryProduct $product) {
        return new Response($product->getRateStat()->getValueNb());
    }

    /**
     * @Route("/product/rate-value/{id}", requirements={"id" = "\d+"}, name="main_product_ratevalue")
     */
    public function rateValueAction(CategoryProduct $product) {
        return new Response($product->getRateStat()->getValue());
    }
    
    /**
     * @Route("/TM/{slug}/product-seo/{id}", requirements={"id" = "\d+"})
     * @Cache(public=true, maxage="86400", smaxage="86400")
     * @ParamConverter("trademark", class="ABOTrademarkBundle:Trademark", options={"mapping": {"slug": "slug"}})
     * @ParamConverter("catProd", class="ABOMainBundle:CategoryProduct", options={"mapping": {"id": "id"} })
     */
    public function productSEOAction(Trademark $trademark, CategoryProduct $catProd) {
        
        return $this->render('ABOMainBundle:Product:productSEO.html.twig', array(
            'trademark' => $trademark,
            'catProd' => $catProd,
        ));
    }
}
