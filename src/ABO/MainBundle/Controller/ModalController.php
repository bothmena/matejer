<?php

namespace ABO\MainBundle\Controller;

use ABO\MainBundle\Entity\CategoryProduct;
use ABO\MainBundle\Entity\ImageShop;
use ABO\MainBundle\Entity\ImageUser;
use ABO\MainBundle\Entity\ProductShop;
use ABO\MainBundle\Form\Product\OfferType;
use ABO\ShopBundle\Entity\Collection;
use ABO\ShopBundle\Entity\CollectionProduct;
use ABO\ShopBundle\Entity\PaymentProduct;
use ABO\ShopBundle\Entity\Shop;
use ABO\ShopBundle\Form\ShopImagesType;
use ABO\UserBundle\Form\Type\UserImagesType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ABO\MainBundle\Entity\Message;
use ABO\MainBundle\Entity\Conversation;

/**
 * @Route("/modal", methods={"GET"})
 */
class ModalController extends Controller {
    
    /**
     * @Route("/{_locale}/colors")
     * @Cache(public=true, smaxage="604800", maxage="604800")
     */
    public function colorAction() {

        $colors = array(
            "line_0" => array("FBEFEF","FBF2EF","FBF5EF","FBF8EF","FBFBEF","F8FBEF","F5FBEF","F2FBEF","EFFBEF","EFFBF2","EFFBF5","EFFBF8","EFFBFB","EFF8FB","EFF5FB","EFF2FB","EFEFFB","F2EFFB","F5EFFB","F8EFFB","FBEFFB","FBEFF8","FBEFF5","FBEFF2","FFFFFF",),
            "line_1" => array("F8E0E0","F8E6E0","F8ECE0","F7F2E0","F7F8E0","F1F8E0","ECF8E0","E6F8E0","E0F8E0","E0F8E6","E0F8EC","E0F8F1","E0F8F7","E0F2F7","E0ECF8","E0E6F8","E0E0F8","E6E0F8","ECE0F8","F2E0F7","F8E0F7","F8E0F1","F8E0EC","F8E0E6","FAFAFA",),
            "line_2" => array("F6CECE","F6D8CE","F6E3CE","F5ECCE","F5F6CE","ECF6CE","E3F6CE","D8F6CE","CEF6CE","CEF6D8","CEF6E3","CEF6EC","CEF6F5","CEECF5","CEE3F6","CED8F6","CECEF6","D8CEF6","E3CEF6","ECCEF5","F6CEF5","F6CEEC","F6CEE3","F6CED8","F2F2F2",),
            "line_3" => array("F5A9A9","F5BCA9","F5D0A9","F3E2A9","F2F5A9","E1F5A9","D0F5A9","BCF5A9","A9F5A9","A9F5BC","A9F5D0","A9F5E1","A9F5F2","A9E2F3","A9D0F5","A9BCF5","A9A9F5","BCA9F5","D0A9F5","E2A9F3","F5A9F2","F5A9E1","F5A9D0","F5A9BC","E6E6E6",),
            "line_4" => array("F78181","F79F81","F7BE81","F5DA81","F3F781","D8F781","BEF781","9FF781","81F781","81F79F","81F7BE","81F7D8","81F7F3","81DAF5","81BEF7","819FF7","8181F7","9F81F7","BE81F7","DA81F5","F781F3","F781D8","F781BE","F7819F","D8D8D8",),
            "line_5" => array("FA5858","FA8258","FAAC58","F7D358","F4FA58","D0FA58","ACFA58","82FA58","58FA58","58FA82","58FAAC","58FAD0","58FAF4","58D3F7","58ACFA","5882FA","5858FA","8258FA","AC58FA","D358F7","FA58F4","FA58D0","FA58AC","FA5882","BDBDBD",),
            "line_6" => array("FE2E2E","FE642E","FE9A2E","FACC2E","F7FE2E","C8FE2E","9AFE2E","64FE2E","2EFE2E","2EFE64","2EFE9A","2EFEC8","2EFEF7","2ECCFA","2E9AFE","2E64FE","2E2EFE","642EFE","9A2EFE","CC2EFA","FE2EF7","FE2EC8","FE2E9A","FE2E64","A4A4A4",),
            "line_7" => array("FF0000","FF4000","FF8000","FFBF00","FFFF00","BFFF00","80FF00","40FF00","00FF00","00FF40","00FF80","00FFBF","00FFFF","00BFFF","0080FF","0040FF","0000FF","4000FF","8000FF","BF00FF","FF00FF","FF00BF","FF0080","FF0040","848484",),
            "line_8" => array("DF0101","DF3A01","DF7401","DBA901","D7DF01","A5DF00","74DF00","3ADF00","01DF01","01DF3A","01DF74","01DFA5","01DFD7","01A9DB","0174DF","013ADF","0101DF","3A01DF","7401DF","A901DB","DF01D7","DF01A5","DF0174","DF013A","6E6E6E",),
            "line_9" => array("B40404","B43104","B45F04","B18904","AEB404","86B404","5FB404","31B404","04B404","04B431","04B45F","04B486","04B4AE","0489B1","045FB4","0431B4","0404B4","3104B4","5F04B4","8904B1","B404AE","B40486","B4045F","B40431","585858",),
            "line_10" => array("8A0808","8A2908","8A4B08","886A08","868A08","688A08","4B8A08","298A08","088A08","088A29","088A4B","088A68","088A85","086A87","084B8A","08298A","08088A","29088A","4B088A","6A0888","8A0886","8A0868","8A084B","8A0829","424242",),
            "line_11" => array("610B0B","61210B","61380B","5F4C0B","5E610B","4B610B","38610B","21610B","0B610B","0B6121","0B6138","0B614B","0B615E","0B4C5F","0B3861","0B2161","0B0B61","210B61","380B61","4C0B5F","610B5E","610B4B","610B38","610B21","2E2E2E",),
            "line_12" => array("3B0B0B","3B170B","3B240B","3A2F0B","393B0B","2E3B0B","243B0B","173B0B","0B3B0B","0B3B17","0B3B24","0B3B2E","0B3B39","0B2F3A","0B243B","0B173B","0B0B3B","170B3B","240B3B","2F0B3A","3B0B39","3B0B2E","3B0B24","3B0B17","1C1C1C",),
            "line_13" => array("2A0A0A","2A120A","2A1B0A","29220A","292A0A","222A0A","1B2A0A","122A0A","0A2A0A","0A2A12","0A2A1B","0A2A22","0A2A29","0A2229","0A1B2A","0A122A","0A0A2A","120A2A","1B0A2A","220A29","2A0A29","2A0A22","2A0A1B","2A0A12","151515",),
            "line_14" => array("190707","190B07","191007","181407","181907","141907","101907","0B1907","071907","07190B","071910","071914","071918","071418","071019","070B19","070719","0B0719","100719","140718","190718","190714","190710","19070B","000000",),
        );
        $html = $this->render('ABOMainBundle:Modal:color.html.twig', array(
            'colors' => $colors,
        ))->getContent();
        return new JsonResponse(['stat'=>'success','template'=>html_entity_decode($html)]);
    }

    /**
     * @Route("/message/{slug}", methods={"POST"}, name="main_modal_message")
     * @Cache(public=false, smaxage="0", maxage="0")
     */
    public function messageAction( Request $request, $slug ) {

        $translator = $this->get('translator');
        $shop = $this->getDoctrine()->getRepository('ABOShopBundle:Shop')->findOneBySlug($slug);
        if(!$shop)
            return new Response('<div data-stat="danger" data-title="'.$translator->trans('not_found.unfound_title').'" data-content="true">'.$translator->trans('not_found.shop').'</div>');

        $message = new Message();
        $form = $this->createForm(\ABO\MainBundle\Form\MessageType::class, $message, array(
            'action' => $this->generateUrl('main_modal_message', array('slug'=>$shop->getSlug())),
        ));
        
        if($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                
                $em = $this->getDoctrine()->getManager();
                $conv = new Conversation();
                $conv->setSubject( $form->get('subject')->getData() );
                $conv->setShop($shop);
                $conv->setUser($this->getUser());
                
                $message->setConversation($conv);
                $message->setSender('user');
                
                $em->persist($conv);
                $em->persist($message);
                $em->flush();
                
//                $this->get('fos_http_cache.handler.tag_handler')
//                    ->invalidateTags(array('sh-ctof-' . $shop->getId(),'sh-nav-' . $shop->getId(),'sog-' . $shop->getId()));
//                $this->get('fos_http_cache.cache_manager')
//                    ->invalidateRoute('shop_parts_offernb', array('slug'=>$shop->getSlug()));
                return new Response('<div data-stat="success" data-form-stat="success" data-title="'.$translator->trans('message.send_success').'" data-content="true">'.$translator->trans('message.send_body', array('%shopname%'=>$shop->getName())).'</div>');
            }
        }
        
        return $this->render('ABOMainBundle:Modal:message.html.twig', array(
            'shop' => $shop,
            'form' => $form->createView(),
        ));
    }
    
    /**
     * @Route("/image-shop", methods={"POST"})
     * @Security("has_role('ROLE_TAJER')")
     * @Cache(public=false, smaxage="0", maxage="0")
     */
    public function shopImageFormAction(Request $request) {

        $shop = $this->getUser()->getMyShop();
        $logos = $this->getDoctrine()->getRepository('ABOMainBundle:ImageShop')->getImagesByType($shop, 'profile');
        $covers = $this->getDoctrine()->getRepository('ABOMainBundle:ImageShop')->getImagesByType($shop, 'cover');
        $form = $this->createForm( ShopImagesType::class, null, array(
            'action' => $this->generateUrl('abo_main_modal_shopimageform'),
            'logos' => $logos,
            'covers' => $covers,
            'loader' => $this->get('abo.file_loader'),
        ));

        if($request->getMethod() === 'POST'){
            $form->handleRequest($request);
            if($form->isValid()){

                $this->shopImgSubmit($shop, $form);
                $this->get('fos_http_cache.handler.tag_handler')
                    ->invalidateTags(array('card-shop-' . $shop->getId(),'sh-nav-' . $shop->getId()));
                return $this->redirect($request->headers->get('referer'));
            }else{
                return $this->redirectToRoute('abo_shop_show_homeadmin');
            }
        }

        return $this->render('ABOMainBundle:Modal:shopImageForm.html.twig', array(
            'form'=>$form->createView()
        ));
    }

    /**
     * @Route("/image-user", methods={"POST"})
     * @Security("has_role('ROLE_USER')")
     * @Cache(public=false, smaxage="0", maxage="0")
     */
    public function userImageFormAction(Request $request) {

        $user = $this->getUser();
        $logos = $this->getDoctrine()->getRepository('ABOMainBundle:ImageUser')->getImages($user);
        $form = $this->createForm( UserImagesType::class, null, array(
            'action' => $this->generateUrl('abo_main_modal_userimageform'),
            'logos' => $logos,
            'loader' => $this->get('abo.file_loader'),
        ));

        if($request->getMethod() === 'POST'){
            $form->handleRequest($request);
            if($form->isValid()){

                $uploader = $this->get('abo.file_uploader');
                $em = $this->getDoctrine()->getManager();
                if( !empty( $form->get('logo')->getData() ) ) {
                    $logo = $uploader->handleImage($form->get('logo')->getData(), $user->getFolder(), 'user', 'profile');
                    $UserImg = new ImageUser($logo, $user);
                    $em->persist($UserImg);
                    $user->setImage($logo);
                }
                else if(!empty( $form->get('logos')->getData())) {
                    $user->setImage( $form->get('logos')->getData()->getImage() );
                }
                $em->persist($user);
                $em->flush();
                $this->get('fos_http_cache.handler.tag_handler')
                    ->invalidateTags(array('usr-nav-' . $user->getId()));
                return $this->redirect($request->headers->get('referer'));
            }
        }

        return $this->render('ABOMainBundle:Modal:userImageForm.html.twig', array(
            'form'=>$form->createView()
        ));
    }

    /**
     * @Route("/{_locale}/gallery/{slug}")
     * @Cache(public=true, smaxage="604800", maxage="604800")
     */
    public function galleryAction($slug) {

        $translator = $this->get('translator');
        $product = $this->getDoctrine()->getRepository('ABOMainBundle:CategoryProduct')->getProductBySlug($slug);
        if(!$product)
            return new Response('<div data-stat="danger" data-title="'.$translator->trans('not_found.unfound_title').'" data-content="true">'.$translator->trans('not_found.prod_content').'</div>');

        return $this->render('ABOMainBundle:Modal:productGallery.html.twig', array(
            'catProd' => $product,
        ));
    }

    /**
     * @Route("/{_locale}/product/{slug}")
     * @Cache(public=true, smaxage="14400", maxage="14400")
     */
    public function productAction($slug) {

        $translator = $this->get('translator');
        $product = $this->getDoctrine()->getRepository('ABOMainBundle:CategoryProduct')->getProductBySlug($slug);
        if(!$product)
            return new Response('<div data-stat="danger" data-title="'.$translator->trans('not_found.unfound_title').'" data-content="true">'.$translator->trans('not_found.prod_content').'</div>');

        $prod = $product->getParent() ? [$product, $product->getParent()] : [$product];
        $images = $this->getDoctrine()->getRepository('ABOMainBundle:ImageProduct')->findProductImages($prod);
        return $this->render('ABOMainBundle:Modal:productInfo.html.twig', array(
            'catProd' => $product,
            'images' => $images,
        ));
    }

    /**
     * @Route("/{_locale}/shop/{slug}")
     * @Cache(public=true, smaxage="14400", maxage="14400")
     */
    public function shopAction($slug) {

        $translator = $this->get('translator');
        $shop = $this->getDoctrine()->getRepository('ABOShopBundle:Shop')->getShop($slug, true);
        if(!$shop){
            return new JsonResponse(array(
                'stat' => 'danger',
                'title' => $translator->trans('not_found.unfound_title'),
                'content' =>  $translator->trans('not_found.shop_content')
            ));
        }
        $this->get('fos_http_cache.handler.tag_handler')
            ->addTags(['mdl-shop-' . $shop->getId()]);

        $categories = $this->getDoctrine()->getRepository('ABOShopBundle:CategoryShop')->getCategories($shop);
        return $this->render('ABOMainBundle:Modal:shopInfo.html.twig', array(
            'shop'=>$shop,
            'categories' => $categories,
        ));
    }

    /**
     * @Route("/{_locale}/offer/{id}")
     * @Cache(public=true, smaxage="14400", maxage="14400")
     */
    public function offerAction($id) {

        $translator = $this->get('translator');
        $offer = $this->getDoctrine()->getRepository('ABOMainBundle:ProductShop')->getSinglePS($id);
        if(!$offer)
            return new JsonResponse(array(
                'stat'=>'danger',
                'title' => $translator->trans('not_found.unfound_title'),
                'content' =>  $translator->trans('not_found.offer_content')
            ));
        $this->get('fos_http_cache.handler.tag_handler')->addTags([
            'mof', 'mof-' . $offer->getId(), 'mofs-' . $offer->getShop()->getId()
        ]);

        $prod = $offer->getCategoryProduct()->getParent() ? [$offer->getCategoryProduct(), $offer->getCategoryProduct()->getParent()] : [$offer->getCategoryProduct()];
        $images = $this->getDoctrine()->getRepository('ABOMainBundle:ImageProduct')->findProductImages($prod);
        $payments = $this->getDoctrine()->getRepository('ABOShopBundle:PaymentProduct')->getOfferPayments($offer);
        return $this->render('ABOMainBundle:Modal:offerInfo.html.twig', array(
            'offer' => $offer,
            'images' => $images,
            'payments'=>$payments,
        ));
    }

    /**
     * @Route("/offer-form/{slug}", methods={"POST"})
     * @Cache(public=false, smaxage="0", maxage="0")
     * @Security("has_role('ROLE_TAJER')")
     */
    public function offerFormAction(Request $request, $slug) {

        $translator = $this->get('translator');
        $shop = $this->getUser()->getMyShop();
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('ABOMainBundle:CategoryProduct')->getProductBySlug($slug);
        if(!$product)
            return new Response('<div data-stat="danger" data-title="'.$translator->trans('not_found.unfound_title').'" data-content="true">'.$translator->trans('not_found.prod_content').'</div>');
        $catShop = $em->getRepository('ABOShopBundle:CategoryShop')->findOneBy(array(
            'shop'=>$shop, 'category'=>$product->getCategory()
        ));
        if(!$catShop)
            return new Response('<div data-stat="danger" data-title="'.$translator->trans('access_denied.error_title').'" data-content="true">'.$translator->trans('access_denied.cant_add_offer').'</div>');
        $productShop = new ProductShop();
        $form = $this->createForm( OfferType::class, $productShop, array(
            'shop'=>$shop,
            'category'=>$product->getCategory(),
        ));
        
        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $productShop->setCategoryProduct($product);
                $productShop->setShop($shop);
                /** @var Shop $shop */
                $shop->setOfferNb( $shop->getOfferNb() + 1 );
                foreach ( $form->get('collection')->getData() as $collection ) {
                    $colProd = new CollectionProduct($productShop, $collection);
                    /** @var Collection $collection */
                    $collection->setProductNb( $collection->getProductNb() + 1 );
                    $em->persist($colProd);
                }
                foreach ( $form->get('payment')->getData() as $pay ) {
                    $payProd = new PaymentProduct($productShop, $pay);
                    $em->persist($payProd);
                }
                $catShop->setProductNb( $catShop->getProductNb() + 1 );
                $em->persist($productShop);
                $em->flush();
                $this->get('fos_http_cache.handler.tag_handler')
                    ->invalidateTags(array('sh-ctof-' . $shop->getId(),'sh-nav-' . $shop->getId(),'sog-' . $shop->getId()));
                $this->get('fos_http_cache.cache_manager')
                    ->invalidateRoute('shop_parts_offernb', array('slug'=>$shop->getSlug()));
                return new Response('<div data-stat="success" data-form-stat="success" data-title="'.$translator->trans('matejer_offer.form_modal.title').'" data-content="true">'.$translator->trans('matejer_offer.form_modal.content', array('%prodname%'=>$product->getProduct()->getName() )).'</div>');
            }
        }
        
        return $this->render('ABOMainBundle:Modal:productShopForm.html.twig', array(
            'prod' => $product,
            'form' => $form->createView(),
            'shop' => $shop,
        ));
    }

    /**
     * @Route("/{_locale}/help/{group}")
     * @Cache(public=true, smaxage="604800", maxage="604800")
     */
    public function helpAction($group) {

        switch ($group){
            case 'sign-up':
                $data = array(
                    ['title'=>'matejer_help.email_title', 'content'=>'matejer_help.email'],
                    ['title'=>'matejer_help.pass_title', 'content'=>'matejer_help.password'],
                    ['title'=>'matejer_help.name_title', 'content'=>'matejer_help.name']);
                break;
            case 'terms':
                $data = [['title'=>'matejer_help.terms_title', 'content'=>'matejer_help.terms']];
                break;
            case 'username':
                $data = [['title'=>'matejer_help.username_title', 'content'=>'matejer_help.username']];
                break;
            case 'shop-terms':
                $data = [['title'=>'matejer_help.shop_terms_title', 'content'=>'matejer_help.shop_terms']];
                break;
            default :
                $translator = $this->get('translator');
                return new Response('<div data-stat="danger" data-title="'.$translator->trans('matejer_help.unfound_group_title').'" data-content="true">'.$translator->trans('matejer_help.unfound_group').'</div>');
        }

        return $this->render('ABOMainBundle:Modal:help.html.twig', ['data' => $data]);
    }

    /**
     * @Route("/esi-{_locale}/product/part/images/{id}")
     * @Cache(public=true, smaxage="604800", maxage="604800")
     */
    public function imagesAction(CategoryProduct $categoryProduct){

        $prod = $categoryProduct->getParent() ? [$categoryProduct, $categoryProduct->getParent()] : [$categoryProduct];
        $images = $this->getDoctrine()->getRepository('ABOMainBundle:ImageProduct')->findProductImages($prod);

        return $this->render('@ABOMain/Modal/images.html.twig', array(
            'catProd' => $categoryProduct,
            'images' => $images,
        ));
    }

    /**
     * @Route("/esi-{_locale}/product/part/details/{id}")
     * @Cache(public=true, smaxage="14400", maxage="14400")
     */
    public function detailsAction(CategoryProduct $categoryProduct){

        return $this->render('@ABOMain/Modal/details.html.twig', array(
            'catProd' => $categoryProduct,
        ));
    }

    /**
     * @Route("/esi/product/part/trailer/{id}")
     * @Cache(public=true, smaxage="14400", maxage="14400")
     */
    public function trailerAction(CategoryProduct $categoryProduct){

        return $this->render('@ABOMain/Modal/trailer.html.twig', array(
            'genSpecs' => $categoryProduct->getGeneralSpecs(),
        ));
    }

    private function shopImgSubmit($shop, $form){

        $change = false;
        $uploader = $this->get('abo.file_uploader');
        $em = $this->getDoctrine()->getManager();
        if( !empty( $form->get('logo')->getData() ) ) {
            $logo = $uploader->handleImage($form->get('logo')->getData(), $shop->getFolder(), 'shop', 'profile');
            $imgShop = new ImageShop($shop, $logo);
            $em->persist($imgShop);
            $shop->setImage($logo);
            $change = true;
        }
        else if(!empty( $form->get('logos')->getData())) {
            $shop->setImage( $form->get('logos')->getData()->getImage() );
            $change = true;
        }
        if( !empty( $form->get('cover')->getData() ) ) {
            $cover = $uploader->handleImage($form->get('cover')->getData(), $shop->getFolder(), 'shop', 'cover');
            $imgShop = new ImageShop($shop, $cover);
            $em->persist($imgShop);
            $shop->setCover($cover);
            $change = true;
        }
        else if(!empty($form->get('covers')->getData())) {
            $shop->setCover( $form->get('covers')->getData()->getImage() );
            $change = true;
        }
        if($change) {
            $em->persist($shop);
            $em->flush();
        }
    }
}
