<?php

namespace ABO\ShopBundle\Controller;

use ABO\MainBundle\Entity\Category;
use ABO\MainBundle\Entity\CategoryProduct;
use ABO\MainBundle\Entity\ProductShop;
use ABO\MainBundle\Event\ValidProductSubmissionEvent;
use ABO\MainBundle\Form\Product\CategoryProductShopType;
use ABO\MainBundle\Form\Product\OfferType;
use ABO\ShopBundle\Entity\Collection;
use ABO\ShopBundle\Entity\CollectionProduct;
use ABO\ShopBundle\Entity\PaymentProduct;
use ABO\ShopBundle\Entity\Shop;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("is_granted('ROLE_TAJER')")
 * @Route("/myShop", methods={"GET"}, host="seller.matejer.local")
 * @Cache(public=false, maxage="0", smaxage="0")
 */
class ProductAdminController extends Controller {
    
    /**
     * @Route("/new-product/select-category", methods={"POST"})
     */
    public function preAddAction(Request $request) {

        $shop = $this->getUser()->getMyShop();
        if(!$shop)
            throw $this->createAccessDeniedException($this->get('translator')->trans('access_denied.has_not_shop'));

        $catShop = $this->getDoctrine()->getRepository('ABOShopBundle:CategoryShop')->getCategories($shop);
        $categories = array();
        foreach ($catShop as $value)
            array_push($categories, $value->getCategory());

        $form = $this->createFormBuilder()
            ->add('category', EntityType::class, array(
                'choices' => $categories,
                'class' => 'ABOMainBundle:Category',
                'label' => 'matejer_category.category',
                'choice_translation_domain' => 'messages',
                'placeholder' => 'matejer_category.category',
                'choice_label' => 'translatable',
                'group_by' => 'parent.translatable',
                'attr' => array(
                    'class' => 'form-control'
                ),
            ))->getForm();
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            return $this->redirectToRoute('abo_shop_productadmin_add',array( 'slug'=>$form->get('category')->getData()->getSlug() ));
        }
        
        return $this->render('ABOShopBundle:ProductAdmin:preAdd.html.twig', array(
            'shop' => $shop,
            'form' => $form->createView(),
            'admin' => true,
        ));
    }

    /**
     * @Route("/new-product/{slug}", methods={"POST"})
     */
    public function addAction(Request $request,Category $category) {

        $shop = $this->getUser()->getMyShop();
        $catShop = $this->getDoctrine()->getRepository('ABOShopBundle:CategoryShop')->findOneBy(array(
            'shop'=>$shop, 'category'=>$category
        ));
        if(!$catShop)
            return $this->createNotFoundException($this->get('translator')->trans('not_found.cat_shop'));
        $catProd = new CategoryProduct();
        $catProd->setShop($shop);
        $catProd->setCategory($category);
        $catTm = $this->getDoctrine()->getRepository('ABOTrademarkBundle:CategoryTrademark')
                ->getCategoryTrademarks($category->getParent());
        $tms = [];
        foreach ($catTm as $value) 
            array_push($tms, $value->getTrademark());
        
        $form = $this->createForm( CategoryProductShopType::class, $catProd, array(
            'action' => $this->generateUrl('abo_shop_productadmin_add', array('slug'=>$category->getSlug())),
            'category' => $category,
            'tms' => $tms,
        ));

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                
                $dispatcher = $this->get('event_dispatcher');
                $event = new ValidProductSubmissionEvent($catProd, $form);
                $dispatcher->dispatch('abo.valid_product_submission', $event);
                switch ($form['afterSubmit']->getData()){
                    case 'same_cat':
                        return $this->redirect($this->generateUrl('abo_shop_productadmin_add',array('slug'=>$category->getSlug())));
                    case 'new_cat':
                        return $this->redirect($this->generateUrl('abo_shop_productadmin_preadd'));
                    case 'offer':
                        return $this->redirect($this->generateUrl('abo_shop_productadmin_product',array('slug'=>$catProd->getProduct()->getSlug())));
                    case 'shop_home':
                        return $this->redirect($this->generateUrl('abo_shop_show_homeadmin'));
                }
            }
        }
        
        return $this->render('ABOShopBundle:ProductAdmin:add.html.twig', array(
            'shop' => $shop,
            'form' => $form->createView(),
            'category' => $category,
        ));
    }
    
    /**
     * @Route("/product/{slug}")
     */
    public function productAction( $slug ) {
        
        $shop = $this->getUser()->getMyShop();
        $productShop = $this->getDoctrine()->getRepository('ABOMainBundle:ProductShop')
            ->getPSBySlug( $slug, $shop );
        if(!$productShop)
            throw $this->createNotFoundException($this->get('translator')->trans('not_found.offer'));
        $features = $this->getDoctrine()->getRepository('ABOMainBundle:FeatureProduct')
            ->findBy(array('categoryProduct' => $productShop->getCategoryProduct()));
        $prodPays = $this->getDoctrine()->getRepository('ABOShopBundle:PaymentProduct')
            ->findBy(array('productShop'=>$productShop));

        return $this->render('ABOShopBundle:ProductAdmin:product.html.twig', array(
            'shop' => $shop,
            'offer' => $productShop,
            'prodPays' => $prodPays,
            'features' => $features,
        ));
    }
    
    /**
     * @Route("/prod-offer/{id}", methods={"POST"})
     */
    public function offerFormAction(Request $request, ProductShop $productShop) {

        $shop = $this->getUser()->getMyShop();
        $prodCols = $this->getDoctrine()->getRepository('ABOShopBundle:CollectionProduct')
            ->findBy(array('productShop'=>$productShop));
        $prodPays = $this->getDoctrine()->getRepository('ABOShopBundle:PaymentProduct')
            ->findBy(array('productShop'=>$productShop));
        $form = $this->createForm( OfferType::class, $productShop, array(
            'method'=> 'POST',
            'action' => $this->generateUrl('abo_shop_productadmin_offerform',array('id'=>$productShop->getId())),
            'shop' => $shop,
            'category' => $productShop->getCategoryProduct()->getCategory(),
            'collections' => $this->cPToC($prodCols),
            'payments' => $this->pPToP($prodPays),
        ));
        
        if($request->getMethod() === 'POST'){
            $form->handleRequest($request);
            if($form->isValid()){
                $this->submitOffer($shop, $productShop, $form, $prodCols, $prodPays);
            }
            return $this->redirectToRoute('abo_shop_productadmin_product', array('slug'=>$productShop->getCategoryProduct()->getProduct()->getSlug()));
        }
        
        return $this->render('ABOShopBundle:ProductAdmin:offerForm.html.twig', array(
            'form'=>$form->createView(),
        ));
    }

    /**
     * @Route("/all-products/{page}", requirements={"page" = "\d+"}, defaults={"page" = 1})
     */
    public function allProductsAction(Request $request, $page) {

        $shop = $this->getUser()->getMyShop();
        $this->get('fos_http_cache.handler.tag_handler')->addTags(['sofs-'. $shop->getId()]);

        $query = $this->getDoctrine()->getRepository('ABOMainBundle:ProductShop')
                    ->getShopProducts($shop);

        $products = $this->get('knp_paginator')->paginate( $query, $request->query->getInt('page', $page), 15);
        if(empty($products->getItems()) && $page > 1)
            throw $this->createNotFoundException($this->get('translator')->trans('not_found.page'));
        
        return $this->render('ABOShopBundle:ProductAdmin:allProducts.html.twig', array(
            'shop' => $shop,
            'products' => $products,
        ));
    }

    /**
     * @Route("/products/{slug}/{page}", requirements={"page" = "\d+"}, defaults={"page" = 1})
     */
    public function prodByCategoryAction(Category $category,$page,Request $request) {

        $shop = $this->getUser()->getMyShop();
        $this->get('fos_http_cache.handler.tag_handler')->addTags([
            'sofsc-'. $shop->getId(),
            'sofsc-'. $shop->getId() . '-' . $category->getId(),
        ]);

        $query = $this->getDoctrine()->getRepository('ABOMainBundle:ProductShop')
                ->getPSByCategory($shop,$category);

        $products = $this->get('knp_paginator')->paginate( $query, $request->query->getInt('page', $page), 15);
        if(empty($products->getItems()) && $page > 1)
            throw $this->createNotFoundException($this->get('translator')->trans('not_found.page'));
        
        return $this->render('ABOShopBundle:ProductAdmin:prodByCategory.html.twig', array(
            'shop' => $shop,
            'products' => $products,
            'category' => $category,
        ));
    }

    /**
     * @Route("/products/c/{slug}/{page}", requirements={"page" = "\d+"}, defaults={"page" = 1})
     */
    public function prodByCollectionAction(Request $request, Collection $collection, $page) {

        $shop = $this->getUser()->getMyShop();
        $this->get('fos_http_cache.handler.tag_handler')->addTags([
            'sofsco-'. $shop->getId(),
            'sofsco-'. $shop->getId() . '-' . $collection->getId(),
        ]);

        $query = $this->getDoctrine()->getRepository('ABOShopBundle:CollectionProduct')
            ->getCollectionPS($collection);

        $products = $this->get('knp_paginator')->paginate( $query, $request->query->getInt('page', $page), 15);
        if(empty($products->getItems()) && $page > 1)
            throw $this->createNotFoundException($this->get('translator')->trans('not_found.page'));
        
        return $this->render('ABOShopBundle:ProductAdmin:prodByCollection.html.twig', array(
            'shop' => $shop,
            'products' => $products,
            'collection' => $collection,
        ));
    }

    private function submitOffer(Shop $shop, ProductShop $productShop, Form $form, array $prodCols, array $prodPays){

        $em = $this->getDoctrine()->getManager();

        $originalCols = $this->cPToC($prodCols);
        $submittedCols = $form->get('collection')->getData()->toArray();
        foreach ( $submittedCols as $collection ) {
            /** @var Collection $collection */
            if(!in_array($collection, $originalCols)) {
                $colProd = new CollectionProduct($productShop, $collection);
                $collection->setProductNb($collection->getProductNb() + 1);
                $em->persist($colProd);
            }
        }
        foreach ($prodCols as $pc) {
            /** @var CollectionProduct $pc */
            if(!in_array($pc->getCollection(), $submittedCols)) {
                $pc->getCollection()->setProductNb($pc->getCollection()->getProductNb() - 1);
                $em->remove($pc);
            }
        }
        $originalPays = $this->pPToP($prodPays);
        $submittedPays = $form->get('payment')->getData()->toArray();
        foreach ( $submittedPays as $pay ) {
            if(!in_array( $pay, $originalPays )) {
                $payProd = new PaymentProduct($productShop, $pay);
                $em->persist($payProd);
            }
        }
        foreach ($prodPays as $pp) {
            /** @var PaymentProduct $pp */
            if(!in_array( $pp->getPayment(), $submittedPays )) {
                $em->remove($pp);
            }
        }
        $em->persist($productShop);
        $em->flush();
        $this->get('fos_http_cache.handler.tag_handler')
            ->invalidateTags(array(
                'sh-nav-' . $shop->getId(), 'sog-' . $shop->getId(),
                'card-offer-' . $productShop->getId(), 'mof-' . $productShop->getId(),
                'oibo-' . $productShop->getId(), 'sh-ctof-' . $shop->getId(),
            ));
        $this->get('fos_http_cache.cache_manager')
            ->invalidateRoute('shop_parts_offernb', array('slug'=>$shop->getSlug()));
    }

    private function cPToC(array $arr) {
        $res = [];
        foreach ($arr as $item){
            array_push($res, $item->getCollection());
        }
        return $res;
    }

    private function pPToP(array $arr) {
        $res = [];
        foreach ($arr as $item)
            /** @var PaymentProduct $item */
            array_push($res, $item->getPayment());
        return $res;
    }
}
