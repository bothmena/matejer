<?php

namespace ABO\UserBundle\Controller;

use ABO\MainBundle\Form\CategoryType;
use ABO\UserBundle\Entity\User;
use FOS\HttpCacheBundle\Configuration\Tag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Security("is_granted('ROLE_USER')")
 * @Cache(public=true, maxage="14400", smaxage="14400")
 * @Route("/myProfile")
 */
class ProfileController extends Controller {
    
    /**
     * @Route("", methods={"GET"})
     * @Cache(public=false, maxage="0", smaxage="0")
     */
    public function showAction(){

        return $this->render('FOSUserBundle:Profile:show.html.twig');
    }

    /**
     * @Route("/{_locale}/prf-cnt/{id}", methods={"GET"})
     * @Tag(expression="'usr-cnt-' ~ user.getId()")
     */
    public function profileContentAction(User $user){

        if($user != $this->getUser())
            return $this->createAccessDeniedException();

        return $this->render('FOSUserBundle:Profile:profileContent.html.twig', array(
            'user' =>$user,
        ));
    }

    /**
     * @Route("/{_locale}/nav/{id}", methods={"GET", "POST"})
     * @Tag(expression="'usr-nav-' ~ user.getId()")
     */
    public function navigationAction(User $user) {

        if($user != $this->getUser())
            return $this->createAccessDeniedException();

        $categories = $this->getDoctrine()->getRepository('ABOMainBundle:CategoryUser')
            ->userCategories($user);
        $cats = $this->get('abo.category')->catsToArray($categories);
        
        return $this->render('FOSUserBundle:Profile:navigation.html.twig', array(
            'user' => $user,
            'categories' => $cats,
        ));
    }
    
    /**
     * @Route("/categories", methods={"GET", "POST"})
     * @Cache(public=false, maxage="0", smaxage="0")
     */
    public function categoriesAction(Request $request) {
        
        $user = $this->getUser();

        $catService = $this->get('abo.category');
        $form = $this->createForm( CategoryType::class, null, array(
            'categories' => $catService->getCats(),
            'action' => $this->generateUrl('abo_user_profile_categories'),
        ));

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $catService->user($form, $user);
                $this->get('fos_http_cache.handler.tag_handler')
                    ->invalidateTags(array('usr-nav-' . $user->getId()));
                $this->get('fos_http_cache.cache_manager')
                    ->invalidateRoute('user_profile_catsnb', array('id'=>$user->getId()));
                return $this->redirect($this->generateUrl('abo_user_profile_show'));
            }
        }
        
        $userCategories = $this->getDoctrine()->getRepository('ABOMainBundle:CategoryUser')
            ->userCategories($user);

        return $this->render('FOSUserBundle:Profile:setCategories.html.twig', array(
            'form' => $form->createView(),
            'userCategories' => $userCategories,
        ));
    }
    
    /**
     * @Route("/categories/remove/{id}", requirements={"id" = "\d+"}, methods={"POST"})
     * @Cache(public=false, maxage="0", smaxage="0")
     */
    public function removeCategoryAction($id) {

        $user = $this->getUser();
        $translator = $this->get('translator');
        $em = $this->getDoctrine()->getManager();
        $catU = $em->getRepository('ABOMainBundle:CategoryUser')->findOneBy(array('user'=>$user,'id'=>$id));

        if($catU){
            $em->remove($catU);
            $em->flush();
            $this->get('fos_http_cache.handler.tag_handler')
                ->invalidateTags(array('usr-nav-' . $user->getId()));
            $this->get('fos_http_cache.cache_manager')
                ->invalidateRoute('user_profile_catsnb', array('id'=>$user->getId()));
            return new JsonResponse(array(
                'stat'=>'success',
                'title' => $translator->trans('category_setting_page.success_title'),
                'content'=>  '',
            ));
        }else{
            return new JsonResponse(array(
                'stat'=>'danger',
                'title' => $translator->trans('category_setting_page.error_title'),
                'content'=>  $translator->trans('category_setting_page.cat_user_unfound'),
            ));
        }
    }

    /**
     * @Route("/cats-nb/{id}", requirements={"id" = "\d+"}, methods={"GET", "POST"}, name="user_profile_catsnb")
     */
    public function catsNbAction(User $user){
        $categoriesNb = $this->getDoctrine()->getRepository('ABOMainBundle:CategoryUser')->userCategoriesNb($user);
        return new Response($categoriesNb);
    }

    /**
     * @Route("/prods-nb/{id}", requirements={"id" = "\d+"}, methods={"GET", "POST"}, name="user_profile_prodsnb")
     */
    public function prodsNbAction(User $user){
        $productsNb = $this->getDoctrine()->getRepository('ABOMainBundle:Wishlist')->wishListProdsNb($user);
        return new Response($productsNb);
    }

    /**
     * @Route("/shops-nb/{id}", requirements={"id" = "\d+"}, methods={"GET", "POST"}, name="user_profile_shopsnb")
     */
    public function shopsNbAction(User $user){
        $userShopsNb = $this->getDoctrine()->getRepository('ABOShopBundle:ShopUser')->userShopsNb($user);
        return new Response($userShopsNb);
    }

    /**
     * @Route("/reviews-nb/{id}", requirements={"id" = "\d+"}, methods={"GET", "POST"}, name="user_profile_reviewsnb")
     */
    public function reviewsNbAction(User $user){
        $prodRtNb = $this->getDoctrine()->getRepository('ABOMainBundle:RatingProduct')->userProdsRtNb($user);
        $shopRtNb = $this->getDoctrine()->getRepository('ABOMainBundle:RatingShop')->userShopsRtNb($user);
        return new Response($prodRtNb + $shopRtNb);
    }

    /**
     * @Tag(expression="'lst-shop-' ~ user.getId()")
     * @Route("/last-shops/{_locale}/{id}", requirements={"id" = "\d+"}, methods={"GET", "POST"}, name="user_profile_lastshops")
     */
    public function lastShopsAction(User $user){
        $lastShops = $this->getDoctrine()->getRepository('ABOShopBundle:ShopUser')->getLastUserShops($user);
        return $this->render('FOSUserBundle:Profile:lastShops.html.twig', array(
            'lastShops' => $lastShops,
        ));
    }

    /**
     * @Tag(expression="'lst-prod-' ~ user.getId()")
     * @Route("/last-prods/{_locale}/{id}", requirements={"id" = "\d+"}, methods={"GET", "POST"}, name="user_profile_lastprods")
     */
    public function lastProdsAction(User $user){
        $lastProducts = $this->getDoctrine()->getRepository('ABOMainBundle:Wishlist')->getUserLastProducts($user);
        return $this->render('FOSUserBundle:Profile:lastProds.html.twig', array(
            'lastProducts' => $lastProducts,
        ));
    }
}
