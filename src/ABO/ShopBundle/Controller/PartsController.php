<?php

namespace ABO\ShopBundle\Controller;

use ABO\ShopBundle\Entity\Shop;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\HttpCacheBundle\Configuration\Tag;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Cache(public=true, maxage="14400", smaxage="14400")
 * @Route("/{slug}/parts", methods={"GET"}, host="matejer.local")
 */
class PartsController extends Controller {

    /**
     * @Route("/cats-nb", methods={"POST"}, name="shop_parts_catsnb")
     */
    public function catsNbAction(Shop $shop){
        $categoriesNb = $this->getDoctrine()->getRepository('ABOShopBundle:CategoryShop')->shopCategoriesNb($shop);
        return new Response($categoriesNb);
    }

    /**
     * @Route("/subs-nb", methods={"POST"}, name="shop_parts_subsnb")
     */
    public function subsNbAction(Shop $shop){
        return new Response($shop->getClientNb());
    }

    /**
     * @Route("/offer-nb", methods={"POST"}, name="shop_parts_offernb")
     */
    public function offerNbAction(Shop $shop){
        return new Response($shop->getOfferNb());
    }

    /**
     * @Route("/shop-name", methods={"POST"}, name="shop_parts_shopname")
     */
    public function shopNameAction(Shop $shop) {
        return new Response($shop->getName());
    }

    /**
     * @Route("/rate-value", methods={"POST"}, name="shop_parts_ratevalue")
     */
    public function rateValueAction(Shop $shop) {
        return new Response($shop->getRateStat()->getValue());
    }

    /**
     * @Route("/rate-nb", methods={"POST"}, name="shop_parts_ratenb")
     */
    public function rateNbAction(Shop $shop) {
        return new Response( $this->get('translator')->transChoice('matejer_review.reviews_choice', $shop->getRateStat()->getValueNb(), array('%count%' => $shop->getRateStat()->getValueNb())) );
    }

    /**
     * @Route("/{_locale}/last-prods", methods={"POST"}, name="shop_parts_lastprods")
     * @Tag(expression="'slast-prod-' ~ shop.getId()")
     */
    public function lastProdsAction(Shop $shop) {

        $products = $this->getDoctrine()->getRepository('ABOMainBundle:ProductShop')->getLastPS($shop,5);

        return $this->render('ABOShopBundle:Parts:lastProds.html.twig', array(
            'products' => $products,
            'shop'=>$shop,
        ));
    }

    /**
     * @Route("/{_locale}/last-subs", methods={"POST"}, name="shop_parts_lastsubs")
     * @Tag(expression="'slast-sub-' ~ shop.getId()")
     */
    public function lastSubsAction(Shop $shop) {

        $followers = $this->getDoctrine()->getRepository('ABOShopBundle:ShopUser')->getLastFollowers($shop,5);

        return $this->render('ABOShopBundle:Parts:lastSubs.html.twig', array(
            'followers' => $followers,
        ));
    }

    /**
     * @Route("/{_locale}/last-reviews", methods={"POST"}, name="shop_parts_lastreviews")
     * @Tag(expression="'slast-rv-' ~ shop.getId()")
     */
    public function lastReviewsAction(Shop $shop) {

        $reviews = $this->getDoctrine()->getRepository('ABOMainBundle:RatingShop')->getLastReviews($shop,5);

        return $this->render('ABOShopBundle:Parts:lastReviews.html.twig', array(
            'reviews' => $reviews,
        ));
    }
}
