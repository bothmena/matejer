<?php

namespace ABO\TrademarkBundle\Controller;

use ABO\MainBundle\Entity\Category;
use ABO\MainBundle\Entity\CategoryProduct;
use ABO\MainBundle\Entity\FeatureProduct;
use ABO\MainBundle\Entity\GeneralSpec;
use ABO\MainBundle\Entity\Product;
use ABO\MainBundle\Entity\TagProduct;
use ABO\MainBundle\Event\ValidProductSubmissionEvent;
use ABO\MainBundle\Event\ValidSpecificationSubmissionEvent;
use ABO\MainBundle\Form\Product\CategoryProductModelType;
use ABO\MainBundle\Form\Product\CategoryProductTMType;
use ABO\MainBundle\Form\Product\PreAddType;
use ABO\MainBundle\Form\Specification\ProductFeaturesType;
use ABO\MainBundle\Form\Specification\SpecificationType;
use ABO\TrademarkBundle\Entity\Arrangement;
use ABO\TrademarkBundle\Entity\Trademark;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 * @Route("/{slug}", methods={"GET"})
 * @Cache(public=false, maxage="0", smaxage="0")
 */
class ProductController extends Controller {
    
    /**
     * @Route("/new-product/select-category", methods={"POST"})
     */
    public function preAddAction(Request $request,Trademark $trademark) {

        $catTm = $this->getDoctrine()->getRepository('ABOTrademarkBundle:CategoryTrademark')->getCategories($trademark);
        $categories = array();
        foreach ($catTm as $value)
            array_push($categories, $value->getCategory());

        $parents = $this->getDoctrine()->getRepository('ABOMainBundle:CategoryProduct')
            ->getParentProduct();
        
        $form = $this->createForm( PreAddType::class, null, array(
            'categories'=>$categories,//($categories, $parents)
            'parents' => $parents,
            'action' => $this->generateUrl('abo_trademark_product_preadd', array('slug' => $trademark->getSlug())),
        ));
        
        $form->handleRequest($request);
        if($request->getMethod() === 'POST') {
            if ($form->isValid()) {

                if($form->get('parent')->getData())
                    return $this->redirect($this->generateUrl('abo_trademark_product_addmodel'
                        ,array('slug'=>$trademark->getSlug(),'parent_slug'=>$form->get('parent')->getData()->getProduct()->getSlug())));
                return $this->redirectToRoute('abo_trademark_product_add',
                    array('slug' => $trademark->getSlug(), 'slug_cat' => $form->get('category')->getData()->getSlug()));
            }
        }
        
        return $this->render('ABOTrademarkBundle:Product:preAdd.html.twig', array(
            'trademark' => $trademark,
            'cats' => $catTm,
            'form' => $form->createView(),
        ));
    }
    
    /**
     * @Route("/new-product/{slug_cat}", methods={"POST"})
     */
    public function addAction(Request $request, $slug, $slug_cat) {
        
        $trademark = $this->getDoctrine()->getRepository('ABOTrademarkBundle:Trademark')->findOneBy(array('slug' => $slug));
        $category = $this->getDoctrine()->getRepository('ABOMainBundle:Category')->findOneBy(array('slug' => $slug_cat));
        if(!$category)
            throw $this->createNotFoundException('category not found');
        if(!$trademark)
            throw $this->createNotFoundException('brand not found');
        $catProd = new CategoryProduct();
        $catProd->setTrademark($trademark);
        $catProd->setCategory($category);
        
        $form = $this->createForm( CategoryProductTMType::class, $catProd, array(
            'category' => $category,
            'trademark' => $trademark,
            'action' => $this->generateUrl('abo_trademark_product_add', array('slug' => $slug, 'slug_cat' => $slug_cat)),
        ));
        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $dispatcher = $this->get('event_dispatcher');
                $event = new ValidProductSubmissionEvent($catProd, $form);
                $dispatcher->dispatch('abo.valid_product_submission', $event);
                return $this->redirectAS($form['afterSubmit']->getData(), $trademark, $catProd);
            }
        }
        
        return $this->render('ABOTrademarkBundle:Product:add.html.twig', array(
            'trademark' => $trademark,
            'form' => $form->createView(),
            'slug_cat' => $slug_cat,
        ));
    }

    /**
     * @Route("/new-model/{parent_slug}", methods={"POST"})
     * @ParamConverter("trademark", options={"mapping": {"slug": "slug"}})
     * @ParamConverter("parent", class="ABOMainBundle:CategoryProduct", options={
     *    "repository_method" = "getParentBySlug",
     *    "mapping": {"parent_slug": "slug"},
     *    "map_method_signature" = true
     * })
     */
    public function addModelAction(Request $request, Trademark $trademark, CategoryProduct $parent) {

        $catProd = new CategoryProduct();
        $catProd->setTrademark($trademark);
        $catProd->setCategory($parent->getCategory());
        $catProd->setParent($parent);
        $catProd->setImage($parent->getImage());
        $gs = new GeneralSpec();
        $catProd->setGeneralSpecs($gs->setData($parent->getGeneralSpecs()));
        $prod = new Product();
        $catProd->setProduct($prod->setData($parent->getProduct()));
        $catProd->setArrangement($parent->getArrangement());
        $pColors = $this->getDoctrine()->getRepository('ABOMainBundle:ProductColor')->getParentColors($parent);
        $colors = [];
        foreach($pColors as $clr)
            array_push($colors, $clr->getColor());

        $form = $this->createForm( CategoryProductModelType::class, $catProd, array(
            'category' => $parent->getCategory(),
            'trademark' => $trademark,
            'colors' => $colors,
            'action' => $this->generateUrl('abo_trademark_product_addmodel', array('slug' => $trademark->getSlug(), 'parent_slug' => $parent->getProduct()->getSlug())),
        ));
        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $dispatcher = $this->get('event_dispatcher');
                $event = new ValidProductSubmissionEvent($catProd, $form);
                $dispatcher->dispatch('abo.valid_product_submission', $event);
                return $this->redirectAS($form['afterSubmit']->getData(), $trademark, $catProd, $parent);
            }
        }

        return $this->render('ABOTrademarkBundle:Product:add.html.twig', array(
            'trademark' => $trademark,
            'form' => $form->createView(),
            'slug_cat' => $parent->getCategory()->getSlug(),
        ));
    }

    private function redirectAS($direction, Trademark $trademark, CategoryProduct $catProd, CategoryProduct $parent = null){

        switch ($direction){
            case 'same_cat':
                return $this->redirect($this->generateUrl('abo_trademark_product_add',array('slug'=>$trademark->getSlug(),'slug_cat'=>$catProd->getCategory()->getSlug())));
            case 'prod_specs':
                return $this->redirect($this->generateUrl('abo_trademark_product_specification',array('slug'=>$trademark->getSlug(),'slug_prod'=>$catProd->getProduct()->getSlug())));
            case 'new_cat':
                return $this->redirect($this->generateUrl('abo_trademark_product_preadd',array('slug'=>$trademark->getSlug())));
            case 'tm_home':
                return $this->redirect($this->generateUrl('abo_trademark_show_home',array('slug'=>$trademark->getSlug())));
            case 'same_mod':
                return $this->redirect($this->generateUrl('abo_trademark_product_addmodel',array('slug'=>$trademark->getSlug(),'parent_slug'=>$parent->getProduct()->getSlug())));
        }
    }
    
    /**
     * @Route("/product-specs/{slug_prod}", methods={"POST"})
     */
    public function specificationAction(Request $request, $slug, $slug_prod) {
        
        $tm = $this->getDoctrine()->getRepository('ABOTrademarkBundle:Trademark')->findOneBySlug($slug);
        if(!$tm)
            $this->createNotFoundException ('Requested trademark not found');
        $catProd = $this->getDoctrine()->getRepository('ABOMainBundle:CategoryProduct')->getProductBySlug($slug_prod);
        if(!$catProd)
            $this->createNotFoundException ('Requested product not found');
        $form = $this->createForm( SpecificationType::class, null, array(
            'action' => $this->generateUrl('abo_trademark_product_specification', array('slug' => $slug, 'slug_prod' => $slug_prod)),
        ) );
        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $dispatcher = $this->get('event_dispatcher');
                $event = new ValidSpecificationSubmissionEvent($catProd, $form);
                $dispatcher->dispatch('abo.valid_specification_submission', $event);
                $this->get('fos_http_cache.handler.tag_handler')
                    ->invalidateTags(array('prod-fich-' . $catProd->getId()));
                return $this->redirect($this->generateUrl('abo_trademark_product_allproducts',array('slug'=>$slug)));
            }
        }
        
        return $this->render('ABOTrademarkBundle:Product:specification.html.twig',array(
            'prod' => $catProd,
            'trademark' => $tm,
            'form'=> $form->createView(),
        ));
    }
    
    /**
     * @Route("/product-features/{slug_prod}", methods={"POST"})
     */
    public function featuresAction(Request $request, $slug, $slug_prod) {
        
        $tm = $this->getDoctrine()->getRepository('ABOTrademarkBundle:Trademark')->findOneBySlug($slug);
        if(!$tm)
            $this->createNotFoundException ('Requested trademark not found');
        $catProd = $this->getDoctrine()->getRepository('ABOMainBundle:CategoryProduct')->getProductBySlug($slug_prod);
        if(!$catProd)
            $this->createNotFoundException ('Requested product not found');
        $form = $this->createForm( ProductFeaturesType::class, null, array(
            'action' => $this->generateUrl('abo_trademark_product_features', array('slug' => $slug, 'slug_prod' => $slug_prod)),
            'category' => $catProd->getCategory(),
            'trademark' => $tm,
        ) );
        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $tags = [];
                $em = $this->getDoctrine()->getManager();
                foreach ($form->get('feature')->getData() as $feature) {

                    if( !$em->getRepository('ABOMainBundle:FeatureProduct')->findOneBy(['feature'=>$feature, 'categoryProduct'=>$catProd]) ){
                        $ftr = new FeatureProduct();
                        $ftr->setCategoryProduct( $catProd );
                        $ftr->setFeature( $feature );
                        array_push( $tags, $feature->getSlug() );
                        $em->persist($ftr);
                    }
                }
                $tagEntities = $em->getRepository('ABOMainBundle:Tag')->findBy(array('type'=>'feature','name'=>$tags));
                foreach ($tagEntities as $tagE) {

                    $tagProduct = new TagProduct();
                    $tagProduct->setCategoryProduct($catProd);
                    $tagProduct->setSlugTag($tagE->getSlug());
                    $tagProduct->setTag($tagE);
                    $em->persist($tagProduct);
                }
                $em->flush();
                return $this->redirect($this->generateUrl('abo_trademark_product_allproducts',array('slug'=>$slug)));
            }
        }
        
        return $this->render('ABOTrademarkBundle:Product:features.html.twig',array(
            'prod' => $catProd,
            'trademark' => $tm,
            'form'=> $form->createView(),
        ));
    }

    /**
     * @Route("/all-products")
     */
    public function allProductsAction(Trademark $trademark) {
        
        $products = $this->getDoctrine()->getRepository('ABOMainBundle:CategoryProduct')->allTMProds($trademark);
        
        return $this->render('ABOTrademarkBundle:Product:allProducts.html.twig', array(
            'trademark' => $trademark,
            'products' => $products,
        ));
    }

    /**
     * @Route("/category/{slug_cat}")
     * @ParamConverter("trademark", options={"mapping": {"slug": "slug"}})
     * @ParamConverter("category", options={"mapping": {"slug_cat": "slug"}})
     */
    public function prodByCategoryAction(Trademark $trademark, Category $category) {

        $products = $this->getDoctrine()->getRepository('ABOMainBundle:CategoryProduct')->allTMProdsByCat($trademark, $category);

        return $this->render('ABOTrademarkBundle:Product:prodByCategory.html.twig', array(
            'trademark' => $trademark,
            'category' => $category,
            'products' => $products,
        ));
    }

    /**
     * @Route("/arrangement/{slug_arr}")
     * @ParamConverter("trademark", options={"mapping": {"slug": "slug"}})
     * @ParamConverter("arrangement", options={"mapping": {"slug_arr": "slug"}})
     */
    public function prodByArrangementAction(Trademark $trademark, Arrangement $arrangement) {

        $products = $this->getDoctrine()->getRepository('ABOMainBundle:CategoryProduct')->allTMProdsByArr($trademark, $arrangement);

        return $this->render('ABOTrademarkBundle:Product:prodByArrangement.html.twig', array(
            'trademark' => $trademark,
            'arrangement' => $arrangement,
            'products' => $products,
        ));
    }

    /**
     * @Route("/product/{slug_prod}")
     */
    public function productAction($slug, $slug_prod) {
        
        $user = $this->getUser();
        $trademark = $this->getDoctrine()->getRepository('ABOTrademarkBundle:Trademark')->findOneBy(array('slug' => $slug));
        
        $catProd = $this->getDoctrine()->getRepository('ABOMainBundle:CategoryProduct')->getProductBySlug($slug_prod);
        if(!$catProd)
            throw $this->createNotFoundException ('product wasn\'t found, pls try later.');

        $this->get('fos_http_cache.handler.tag_handler')->addTags(array(
            'prod-tm-page', 'prod-tm-'.$trademark->getSlug().'-'.$catProd->getProduct()->getSlug()
        ));

        $fiches = $this->getDoctrine()->getRepository('ABOMainBundle:FicheProduct')->findBy(array('categoryProduct' => $catProd));
        $arr = $this->get('abo.util')->ficheToArray($fiches);
                
        $favored = $this->getDoctrine()->getRepository('ABOMainBundle:Wishlist')
            ->findOneBy(array('categoryProduct'=>$catProd,'user'=>$user)) ? true : false;
        
        $features = $this->getDoctrine()->getRepository('ABOMainBundle:FeatureProduct')->findBy(array('categoryProduct' => $catProd));
        
        $userReview = $this->getDoctrine()->getRepository('ABOMainBundle:RatingProduct')->findOneBy(array('categoryProduct' => $catProd,'user'=>$user));
        $reviews = $this->getDoctrine()->getRepository('ABOMainBundle:RatingProduct')->findBy(array('categoryProduct' => $catProd));
        
        return $this->render('ABOTrademarkBundle:Product:product.html.twig', array(
            'trademark' => $trademark, 'catProd' => $catProd,  'favored' => $favored,
            'simpleFiche' => $arr['simple'], 'doubleFiche' => $arr['double'],
            'features' => $features, 'userReview' => $userReview, 'reviews' => $reviews,
        ));
    }
}

