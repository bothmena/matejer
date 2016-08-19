<?php

namespace ABO\MainBundle\Controller;

use ABO\MainBundle\Entity\CategoryProduct;
use ABO\MainBundle\Entity\RatingProduct;
use ABO\MainBundle\Entity\RatingShop;
use ABO\MainBundle\Form\Reviews\RatingProductType;
use ABO\MainBundle\Form\Reviews\RatingShopType;
use ABO\ShopBundle\Entity\Shop;
use FOS\HttpCacheBundle\Configuration\Tag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/reviews", methods={"GET"})
 * @Cache(public=true, maxage="14400", smaxage="14400")
 */
class ReviewController extends Controller {

    /**
     * @Route("/esi-{_locale}/show-user-product/{id}", requirements={"id" = "\d+"})
     * @Security("is_granted('ROLE_USER')")
     * @Cache(public=false, maxage="7200", smaxage="7200")
     * @Tag("upr-rv", expression="'upr-rv-' ~ ratingProduct.getUser().getId()", expression="'upr-rv-' ~ ratingProduct.getId()")
     */
    public function userProdReviewAction(RatingProduct $ratingProduct){

        return $this->render('@ABOMain/Review/userProdReview.html.twig', array(
            'ratingProduct'=>$ratingProduct,
        ));
    }

    /**
     * @Route("/esi-{_locale}/show-user-shop/{id}", requirements={"id" = "\d+"})
     * @Security("is_granted('ROLE_USER')")
     * @Cache(public=false, maxage="7200", smaxage="7200")
     * @Tag("ush-rv", expression="'ush-rv-' ~ ratingShop.getUser().getId()", expression="'ush-rv-' ~ ratingShop.getId()")
     */
    public function userShopReviewAction(RatingShop $ratingShop){

        return $this->render('@ABOMain/Review/userShopReview.html.twig', array(
            'ratingShop'=>$ratingShop,
        ));
    }

    /**
     * @Route("/esi-{_locale}/show-product/{id}", requirements={"id" = "\d+"})
     * @Tag(expression="'prod-rv-' ~ ratingProduct.getId()")
     */
    public function productReviewAction(RatingProduct $ratingProduct){

        return $this->render('@ABOMain/Review/productReview.html.twig', array(
            'ratingProduct'=>$ratingProduct,
        ));
    }

    /**
     * @Route("/esi-{_locale}/show-shop/{id}", requirements={"id" = "\d+"})
     * @Tag(expression="'shop-rv-' ~ ratingShop.getId()")
     */
    public function shopReviewAction(RatingShop $ratingShop){

        return $this->render('@ABOMain/Review/shopReview.html.twig', array(
            'ratingShop'=>$ratingShop,
        ));
    }

    /**
     * @Route("/esi-{_locale}/prod-rate-stat/{id}", requirements={"id" = "\d+"}, name="main_review_prodratestat")
     * @Tag(expression="'prod-rs-' ~ catProd.getId()")
     */
    public function prodRateStatAction(CategoryProduct $catProd){

        return $this->render('@ABOMain/Review/prodRateStat.html.twig', array(
            'catProd'=>$catProd,
        ));
    }

    /**
     * @Route("/esi-{_locale}/shop-rate-stat/{id}", requirements={"id" = "\d+"}, name="main_review_shopratestat")
     * @Tag(expression="'shop-rs-' ~ shop.getId()")
     */
    public function shopRateStatAction(Shop $shop){

        return $this->render('@ABOMain/Review/shopRateStat.html.twig', array(
            'shop'=>$shop,
        ));
    }

    /**
     * @Route("/product/{slug}/new", methods={"POST"})
     * @Security("is_granted('ROLE_USER')")
     * @Cache(public=false, maxage="0", smaxage="0")
     * @ParamConverter("catProd", options={"repository_method" = "getProductBySlug","mapping": {"slug": "slug"},"map_method_signature" = true})
     */
    public function newProdReviewAction(Request $request, CategoryProduct $catProd) {

        $ratingProd = new RatingProduct();
        $ratingProd->setCategoryProduct($catProd);
        $form = $this->createForm( RatingProductType::class, $ratingProd, array(
            'action'=>$this->generateUrl('abo_main_review_newprodreview', array('slug'=>$catProd->getProduct()->getSlug()), true),
            'specsClass' => $catProd->getCategory()->getSpecsClass(),
        ));

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $this->get('fos_http_cache.handler.tag_handler')
                    ->invalidateTags(array('prod-rs-' . $catProd->getId()));
                $this->get('fos_http_cache.cache_manager')
                    ->invalidateRoute('main_product_ratenb', array('id'=>$ratingProd->getCategoryProduct()->getId()))
                    ->invalidateRoute('main_product_ratevalue', array('id'=>$ratingProd->getCategoryProduct()->getId()))
                    ->invalidateRoute('user_profile_reviewsnb', array('id'=>$this->getUser()->getId()));
                return $this->submitProdReview($ratingProd, $catProd, [], true);
            }
            else{
                return $this->prodReviewForm($form, 'error', $ratingProd, true);
            }
        }

        return $this->prodReviewForm($form, 'error', $ratingProd, true, true);
    }

    /**
     * @Route("/shop/{slug}/new", methods={"POST"})
     * @Security("is_granted('ROLE_USER')")
     * @Cache(public=false, maxage="0", smaxage="0")
     */
    public function newShopReviewAction(Request $request, Shop $shop) {

        $ratingShop = new RatingShop();
        $ratingShop->setShop($shop);
        $form = $this->createForm( RatingShopType::class,$ratingShop, array(
            'action'=>$this->generateUrl('abo_main_review_newshopreview', array('slug'=>$shop->getSlug()))
        ));

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                
                $this->get('fos_http_cache.handler.tag_handler')
                    ->invalidateTags(array('shop-rs-' . $shop->getId(), 'slast-rv-' . $shop->getId()));
                $this->get('fos_http_cache.cache_manager')
                    ->invalidateRoute('shop_parts_ratevalue', array('slug'=>$shop->getSlug()))
                    ->invalidateRoute('shop_parts_ratenb', array('slug'=>$shop->getSlug()))
                    ->invalidateRoute('user_profile_reviewsnb', array('id'=>$this->getUser()->getId()));
                return $this->submitShopReview($ratingShop, $shop, [], true);
            }
            else{
                return $this->shopReviewForm($form, 'error', $ratingShop, true);
            }
        }

        return $this->shopReviewForm($form, 'error', $ratingShop, true);
    }

    /**
     * @Route("/product/{id}", requirements={"id" = "\d+"}, defaults={"id" = 0}, methods={"POST"})
     * @Security("is_granted('ROLE_USER')")
     * @Cache(public=false, maxage="0", smaxage="0")
     */
    public function editProdReviewAction(Request $request, RatingProduct $ratingProd) {

        $oldRate = ['value'=>$ratingProd->getRate()->getValue(),
            'valueOne'=>$ratingProd->getRate()->getValueOne(),
            'valueTwo'=>$ratingProd->getRate()->getValueTwo(),
            'valueThree'=>$ratingProd->getRate()->getValueThree(),
            'valueFour'=>$ratingProd->getRate()->getValueFour(),];
        $form = $this->createForm( RatingProductType::class, $ratingProd, array(
            'action'=>$this->generateUrl('abo_main_review_editprodreview', array('id'=>$ratingProd->getId())),
            'specsClass' => $ratingProd->getCategoryProduct()->getCategory()->getSpecsClass(),
        ));

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $catProd = $ratingProd->getCategoryProduct();
                $this->get('fos_http_cache.handler.tag_handler')
                    ->invalidateTags(array('upr-rv-' . $ratingProd->getUser()->getId(),'prod-rs-' . $catProd->getId(),'prod-rv-' . $ratingProd->getId()));
                $this->get('fos_http_cache.cache_manager')
                    ->invalidateRoute('main_product_ratevalue', array('id'=>$ratingProd->getCategoryProduct()->getId()));
                return $this->submitProdReview($ratingProd, $ratingProd->getCategoryProduct(), $oldRate);
            }
            else{
                return $this->prodReviewForm($form, 'error', $ratingProd );
            }
        }

        return $this->prodReviewForm($form, 'error', $ratingProd );
    }

    /**
     * @Route("/shop/{id}", requirements={"id" = "\d+"}, defaults={"id" = 0}, methods={"POST"})
     * @Security("is_granted('ROLE_USER')")
     * @Cache(public=false, maxage="0", smaxage="0")
     */
    public function editShopReviewAction(Request $request, RatingShop $ratingShop) {

        $oldRate = ['value'=>$ratingShop->getRate()->getValue(),
            'valueOne'=>$ratingShop->getRate()->getValueOne(),
            'valueTwo'=>$ratingShop->getRate()->getValueTwo(),
            'valueThree'=>$ratingShop->getRate()->getValueThree(),
            'valueFour'=>$ratingShop->getRate()->getValueFour()];
        $form = $this->createForm(RatingShopType::class, $ratingShop, array(
            'action'=>$this->generateUrl('abo_main_review_editshopreview', array('id'=>$ratingShop->getId()))
        ));

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $this->get('fos_http_cache.handler.tag_handler')
                    ->invalidateTags(array(
                        'ush-rv-' . $ratingShop->getUser()->getId(),
                        'shop-rv-' . $ratingShop->getId(),
                        'shop-rs-' . $ratingShop->getShop()->getId()
                    ));
                $this->get('fos_http_cache.cache_manager')
                    ->invalidateRoute('shop_parts_ratevalue', array('slug'=>$ratingShop->getShop()->getSlug()));
                return $this->submitShopReview($ratingShop, $ratingShop->getShop(), $oldRate);
            }
            else{
                return $this->shopReviewForm($form, 'error', $ratingShop );
            }
        }

        return $this->shopReviewForm($form, 'error', $ratingShop);
    }

    private function submitProdReview(RatingProduct $ratingProd, CategoryProduct $catProd, $oldRate, $isNew = false){

        $ratingProd->setCategoryProduct($catProd);
        $ratingProd->setUser($this->getUser());
        $this->get('abo.review_handler')->updateRateStat($ratingProd, $catProd->getRateStat(), $oldRate);

        return $this->forward('ABOMainBundle:Product:userReviewRS', array(
            'catProd'=>$ratingProd->getCategoryProduct(),
            'isNew' => $isNew,
        ));
    }

    private function submitShopReview(RatingShop $ratingShop, Shop $shop, $oldRate, $isNew = false){

        $ratingShop->setShop($shop);
        $ratingShop->setUser($this->getUser());
        $this->get('abo.review_handler')->updateRateStat($ratingShop, $shop->getRateStat(), $oldRate);

        return $this->forward('ABOShopBundle:Show:userReviewRS', array(
            'shop'=>$ratingShop->getShop(),
            'isNew' => $isNew,
        ));
    }

    private function prodReviewForm($form, $stat, RatingProduct $ratingProd, $isNew = false){

        return $this->render('ABOMainBundle:Review:productReviewForm.html.twig', array(
            'form' => $form->createView(),
            'reviewed'=> $ratingProd->getCategoryProduct()->getProduct()->getName(),
            'id' => $isNew ? 0 : $ratingProd->getId(),
            'isNew' => $isNew,
            'stat' => $stat,
        ));
    }

    private function shopReviewForm($form, $stat, $ratingShop, $isNew = false){

        return $this->render('ABOMainBundle:Review:shopReviewForm.html.twig', array(
            'form' => $form->createView(),
            'reviewed'=> $ratingShop->getShop()->getName(),
            'isNew' => $isNew,
            'stat' => $stat,
            'id' => $isNew ? 0 : $ratingShop->getId(),
        ));
    }
}

