<?php

namespace ABO\MainBundle\Controller;

use ABO\MainBundle\Entity\CategoryProduct;
use ABO\MainBundle\Entity\ProductShop;
use ABO\ShopBundle\Entity\Shop;
use FOS\HttpCacheBundle\Configuration\Tag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Cache(public=true, maxage="14400", smaxage="14400")
 * @Route("", methods={"GET"}, host="matejer.local")
 */
class CardController extends Controller {
    
    /**
     * @Route("/esi-{_locale}/card/product/{id}")
     * @Tag(expression="'card-prod-' ~ prod.getId()")
     */
    public function productAction(CategoryProduct $prod) {
        
        return $this->render('ABOMainBundle:Card:product.html.twig', array('prod'=>$prod));
    }
    
    /**
     * @Route("/esi-{_locale}/card/shop/{id}")
     * @Tag(expression="'card-shop-' ~ shop.getId()")
     */
    public function shopAction(Shop $shop) {
        
        return $this->render('ABOMainBundle:Card:shop.html.twig', array('shop'=>$shop));
    }
    
    /**
     * @Route("/esi-{_locale}/card/offer/{id}")
     * @Tag(expression="'card-offer-' ~ offer.getId()")
     */
    public function offerAction(ProductShop $offer) {
        
        return $this->render('ABOMainBundle:Card:offer.html.twig', array('offer'=>$offer));
    }
}
