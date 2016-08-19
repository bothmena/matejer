<?php

namespace ABO\ShopBundle\Controller;

use ABO\MainBundle\Entity\Category;
use ABO\MainBundle\Entity\ProductShop;
use ABO\ShopBundle\Entity\Collection;
use ABO\ShopBundle\Entity\Shop;
use FOS\HttpCacheBundle\Configuration\Tag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/{slug}", methods={"GET"}, host="matejer.local")
 * @Cache(public=true, maxage="14400", smaxage="14400")
 */
class ProductController extends Controller {

    /**
     * @Route("/product/{slug_prod}")
     * @Cache(public=false, maxage="0", smaxage="0")
     * @ParamConverter("shop", class="ABOShopBundle:Shop", options={"mapping": {"slug": "slug"}})
     */
    public function productAction(Shop $shop, $slug_prod) {

        if($this->get('security.authorization_checker')->isGranted('ROLE_TAJER') && $this->getUser()->getMyShop() === $shop)
            return $this->redirectToRoute('abo_shop_productadmin_product', array('slug'=>$slug_prod));

        $productShop = $this->getDoctrine()->getRepository('ABOMainBundle:ProductShop')
            ->getPSBySlug( $slug_prod, $shop );
        if(!$productShop)
            throw $this->createNotFoundException($this->get('translator')->trans('not_found.offer'));
        $features = $this->getDoctrine()->getRepository('ABOMainBundle:FeatureProduct')
            ->findBy(array('categoryProduct' => $productShop->getCategoryProduct()));

        return $this->render('@ABOShop/Product/product.html.twig', array(
            'shop' => $shop,
            'offer' => $productShop,
            'features' => $features,
        ));
    }

    /**
     * @Route("/product/offer-info/{_locale}/{id}")
     * @ParamConverter("shop", options={"mapping": {"slug": "slug"}})
     * @ParamConverter("productShop", options={"mapping": {"id": "id"}})
     */
    public function offerInfoAction(Shop $shop, ProductShop $productShop){

        $prodPays = $this->getDoctrine()->getRepository('ABOShopBundle:PaymentProduct')
            ->findBy(array('productShop'=>$productShop));
        $prodCols = $this->getDoctrine()->getRepository('ABOShopBundle:CollectionProduct')
            ->findBy(array('productShop'=>$productShop));

        $this->get('fos_http_cache.handler.tag_handler')->addTags(['oibo-' . $productShop->getId(), 'oibs-' . $shop->getId()]);

        return $this->render('@ABOMain/Product/offerInfo.html.twig', array(
            'offer' => $productShop,
            'prodPays'=>$prodPays,
            'prodCols'=>$prodCols,
        ));
    }

    /**
     * @Route("/all-products/{page}", requirements={"page" = "\d+"}, defaults={"page" = 1})
     * @Cache(public=false, maxage="0", smaxage="0")
     * @Tag("sog", expression="'sog-'~shop.getId()")
     */
    public function allProductsAction(Shop $shop,$page,Request $request) {

        if($this->get('security.authorization_checker')->isGranted('ROLE_TAJER') && $this->getUser()->getMyShop() === $shop)
            return $this->redirectToRoute('abo_shop_productadmin_allproducts');

        $this->get('fos_http_cache.handler.tag_handler')->addTags(['ofs-'. $shop->getId()]);

        $query = $this->getDoctrine()->getRepository('ABOMainBundle:ProductShop')
            ->getShopProducts($shop);

        $products = $this->get('knp_paginator')->paginate( $query, $request->query->getInt('page', $page), 15);
        if(empty($products->getItems()) && $page > 1)
            throw $this->createNotFoundException($this->get('translator')->trans('not_found.page'));

        return $this->render('ABOShopBundle:Product:allProducts.html.twig', array(
            'shop' => $shop,
            'products' => $products,
        ));
    }

    /**
     * @Route("/products/{slug_cat}/{page}", requirements={"page" = "\d+"}, defaults={"page" = 1})
     * @ParamConverter("shop", options={"mapping": {"slug": "slug"}})
     * @ParamConverter("category", options={"mapping": {"slug_cat": "slug"}})
     * @Cache(public=false, maxage="0", smaxage="0")
     * @Tag("sog", expression="'sog-'~shop.getId()")
     */
    public function prodByCategoryAction(Shop $shop, Category $category, $page, Request $request) {

        if($this->get('security.authorization_checker')->isGranted('ROLE_TAJER') && $this->getUser()->getMyShop() === $shop)
            return $this->redirectToRoute('abo_shop_productadmin_prodbycategory', array('slug'=>$category->getSlug()));

        $this->get('fos_http_cache.handler.tag_handler')->addTags([
            'ofsc-'. $shop->getId(),
            'ofsc-'. $shop->getId() . '-' . $category->getId()
        ]);
        $query = $this->getDoctrine()->getRepository('ABOMainBundle:ProductShop')
            ->getPSByCategory($shop,$category);

        $products = $this->get('knp_paginator')->paginate( $query, $request->query->getInt('page', $page), 15);
        if(empty($products->getItems()) && $page > 1)
            throw $this->createNotFoundException($this->get('translator')->trans('not_found.page'));
        
        return $this->render('ABOShopBundle:Product:prodByCategory.html.twig', array(
            'shop' => $shop,
            'products' => $products,
            'category' => $category,
        ));
    }

    /**
     * @Route("/products/c/{slug_col}/{page}", requirements={"page" = "\d+"}, defaults={"page" = 1})
     * @ParamConverter("shop", options={"mapping": {"slug": "slug"}})
     * @ParamConverter("collection", options={"mapping": {"slug_col": "slug"}})
     * @Cache(public=false, maxage="0", smaxage="0")
     * @Tag("sog", expression="'sog-'~shop.getId()")
     */
    public function prodByCollectionAction(Shop $shop, Collection $collection, $page, Request $request) {

        if($this->get('security.authorization_checker')->isGranted('ROLE_TAJER') && $this->getUser()->getMyShop() === $shop)
            return $this->redirectToRoute('abo_shop_productadmin_prodbycollection', array('slug'=>$collection->getSlug()));

        $this->get('fos_http_cache.handler.tag_handler')->addTags([
            'ofsco-'. $shop->getId(),
            'ofsco-'. $shop->getId() . '-' . $collection->getId()
        ]);
        $query = $this->getDoctrine()->getRepository('ABOShopBundle:CollectionProduct')
            ->getCollectionPS($collection);

        $products = $this->get('knp_paginator')->paginate( $query, $request->query->getInt('page', $page), 15);
        if(empty($products->getItems()) && $page > 1)
            throw $this->createNotFoundException($this->get('translator')->trans('not_found.page'));
        
        return $this->render('ABOShopBundle:Product:prodByCollection.html.twig', array(
            'shop' => $shop,
            'products' => $products,
            'collection' => $collection,
        ));
    }
    
    /**
     * @Route("/product-seo/{id}", requirements={"id" = "\d+"})
     * @Cache(public=true, maxage="86400", smaxage="86400")
     * @ParamConverter("shop", class="ABOShopBundle:Shop", options={"mapping": {"slug": "slug"}})
     * @ParamConverter("offer", class="ABOMainBundle:ProductShop", options={"mapping": {"id": "id"}})
     */
    public function offerSEOAction(Shop $shop, ProductShop $offer) {
        
        return $this->render('ABOShopBundle:Product:offerSEO.html.twig', array(
            'shop' => $shop,
            'offer' => $offer,
        ));
    }
}
