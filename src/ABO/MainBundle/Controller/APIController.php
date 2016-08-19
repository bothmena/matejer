<?php

namespace ABO\MainBundle\Controller;

use ABO\MainBundle\Entity\CategoryUser;
use ABO\MainBundle\Entity\Wishlist;
use ABO\ShopBundle\Entity\ShopUser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/api", methods={"POST", "GET"})
 */
class APIController extends Controller {

    /**
     * @Route("/check/{id}/product")
     */
    public function isLikedAction($id) {

        $user = $this->getUser();
        $catProd = $this->getDoctrine()->getRepository('ABOMainBundle:CategoryProduct')->find($id);
        if(!$catProd)
            return new JsonResponse(array(
                'stat'=>'danger',
                'title'=>$this->get('translator')->trans('matejer_main.error_occ'),
                'content'=>  $this->get('translator')->trans('access_denied.csrf')
            ));

        $relation = $this->getDoctrine()->getRepository('ABOMainBundle:Wishlist')->findOneBy(['user'=>$user, 'categoryProduct'=>$catProd]);
        return new JsonResponse(array('stat'=>'success','result'=>!empty($relation)));
    }

    /**
     * @Route("/check/{id}/shop")
     */
    public function isSubscribedAction($id) {

        $user = $this->getUser();
        $shop = $this->getDoctrine()->getRepository('ABOShopBundle:Shop')->find($id);
        if(!$shop)
            return new JsonResponse(array(
                'stat'=>'danger',
                'title'=>$this->get('translator')->trans('matejer_main.error_occ'),
                'content'=>  $this->get('translator')->trans('access_denied.csrf')
            ));

        $relation = $this->getDoctrine()->getRepository('ABOShopBundle:ShopUser')->findOneBy(['user'=>$user, 'shop'=>$shop]);
        return new JsonResponse(array('stat'=>'success','result'=>!empty($relation)));
    }
    
    /**
     * @Route("/user-data")
     */
    public function userDataAction(){

        $checker = $this->get('security.authorization_checker');
        if($checker->isGranted('ROLE_USER')){
            $user = $this->getUser();
            $data = array('userProds'=>[], 'userShops'=>[], 'shopProds'=>[], 'shopCats'=>[]);
            //userProds
            $uPs = $this->getDoctrine()->getRepository('ABOMainBundle:Wishlist')->getUSserProds($user);
            foreach ($uPs as $value){
                array_push($data['userProds'], $value->getCategoryProduct()->getId());
            }
            //userShops
            $uSs = $this->getDoctrine()->getRepository('ABOShopBundle:ShopUser')->getLightUserShops($user);
            foreach ($uSs as $value){
                array_push($data['userShops'], $value->getShop()->getSlug());
            }
            if ($checker->isGranted('ROLE_TAJER')) {
                $shop = $user->getMyShop();
                $sPs = $this->getDoctrine()->getRepository('ABOMainBundle:ProductShop')->getLightShopProducts($shop);
                foreach ($sPs as $value){
                    array_push($data['shopProds'], $value->getCategoryProduct()->getId());
                }
                $sCs = $this->getDoctrine()->getRepository('ABOShopBundle:CategoryShop')->getCategories($shop);
                foreach ($sCs as $value){
                    array_push($data['shopCats'], $value->getCategory()->getId());
                }
            }

            return new JsonResponse(array('stat'=>'success','data'=>$data));
        }
        return new JsonResponse(['stat'=>'error', 'error'=>'anonymous_user']);
    }
    
    /**
     * @Route("/is-available/username/{value}")
     */
    public function isAvailableUserAction($value) {

        $translator = $this->get('translator');
        $usermanager = $this->get('fos_user.user_manager');
        $result = empty($usermanager->findUserByUsername($value));

        return new JsonResponse( [
            'stat'=>  !$result ? "warning" : "success",
            'value'=>$value,
            "message"=> $result ? $translator->trans("user_registration_confirmed.username_available",["%username%"=>$value]) :
                $translator->trans("user_registration_confirmed.username_unavailable",["%username%"=>$value]),
        ] );
    }
    
    /**
     * @Route("/subscribe/shop/{slug}")
     * @Security("is_granted('ROLE_USER')")
     */
    public function subscribeShopAction($slug) {

        $user = $this->getUser();

        $translator = $this->get('translator');
        $em = $this->getDoctrine()->getManager();
        $shop = $em->getRepository('ABOShopBundle:Shop')->findOneBy(array('slug'=>$slug));
        if(!$shop)
            return new JsonResponse(array(
                'stat'=>'danger',
                'title' => $translator->trans('matejer_main.error_occ'),
                'content' => $translator->trans('not_found.sub_shop')
            ));
        
        $shop_user = $em->getRepository('ABOShopBundle:ShopUser')->findOneBy(['user'=>$user,'shop'=>$shop]);
        $this->get('fos_http_cache.handler.tag_handler')->invalidateTags(array(
            'slast-sub-' . $shop->getId(),
            'lst-shop-' . $user->getId(),
        ));
        $this->get('fos_http_cache.cache_manager')
            ->invalidateRoute('shop_parts_subsnb', array('slug'=>$slug))
            ->invalidateRoute('user_profile_shopsnb', array('id'=>$user->getId()));

        if($shop_user){
            $shop->setClientNb($shop->getClientNb() - 1);
            $em->remove($shop_user);
            $em->flush();
            return new JsonResponse(['stat'=>'unsubscribed']);
        }else{
            $shop_user = new ShopUser();
            $shop_user->setShop($shop);
            $shop_user->setUser($user);
            $shop->setClientNb($shop->getClientNb() + 1);
            $em->persist($shop_user);
            $em->flush();
            return new JsonResponse(['stat'=>'subscribed']);
        }
    }

    /**
     * @Route("/like/{id}")
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     */
    public function likeProductAction($id) {

        $user = $this->getUser();
        $translator = $this->get('translator');
        $em = $this->getDoctrine()->getManager();
        $catProd = $em->getRepository('ABOMainBundle:CategoryProduct')->find($id);
        if(!$catProd)
            return new JsonResponse(array(
                'stat'=>'danger',
                'title' => $translator->trans('not_found.not_found'),
                'content' => $translator->trans('not_found.prod_content')
            ));
        
        $prodUser = $em->getRepository('ABOMainBundle:Wishlist')->findOneBy(['user'=>$user,'categoryProduct'=>$catProd]);
        $catUser = $em->getRepository('ABOMainBundle:CategoryUser')->findOneBy(['user'=>$user,'category'=>$catProd->getCategory()]);

        if($prodUser){
            $em->remove($prodUser);
            $catProd->getProduct()->setFavoredNb($catProd->getProduct()->getFavoredNb() - 1);
            if($catUser){
                $catUser->setProductNb($catUser->getProductNb() - 1);
                if($catUser->getProductNb() == 0 && !$catUser->getChosen())
                    $em->remove($catUser);
            }
            $msg = 'unliked';
        }
        else{
            $prodUser = new Wishlist($catProd, $user);
            $em->persist($prodUser);
            $catProd->getProduct()->setFavoredNb( $catProd->getProduct()->getFavoredNb() + 1 );
            if($catUser)
                $catUser->setProductNb($catUser->getProductNb() + 1);
            else{
                $catUser = new CategoryUser();
                $catUser->setCategory($catProd->getCategory());
                $catUser->setUser($user);
                $catUser->setChosen(FALSE);
                $catUser->setProductNb(1);
                $em->persist($catUser);
            }
            $msg = 'liked';
        }
        $em->flush();
        $this->get('fos_http_cache.handler.tag_handler')->invalidateTags(array(
            'lst-prod-' . $user->getId(),
            'usr-nav-' . $user->getId(),
        ));
        $cm = $this->get('fos_http_cache.cache_manager');
        $cm->invalidateRoute('main_product_likesnb', array('id'=>$id))
            ->invalidateRoute('user_profile_prodsnb', array('id'=>$user->getId()));

        return new JsonResponse( ['stat'=>$msg] );
    }
}
