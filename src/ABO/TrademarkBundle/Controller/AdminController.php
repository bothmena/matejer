<?php

namespace ABO\TrademarkBundle\Controller;

use ABO\MainBundle\Entity\Feature;
use ABO\MainBundle\Entity\ImageTrademark;
use ABO\MainBundle\Form\CategoryType;
use ABO\MainBundle\Form\Specification\FeatureType;
use ABO\TrademarkBundle\Entity\Arrangement;
use ABO\TrademarkBundle\Entity\Trademark;
use ABO\TrademarkBundle\Form\ArrangementType;
use ABO\TrademarkBundle\Form\TrademarkType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 * @Route("", methods={"GET"})
 * @Cache(public=false, maxage="0", smaxage="0")
 */
class AdminController extends Controller {
    
    /**
     * @Route("/register", methods={"POST"})
     */
    public function registerAction(Request $request) {
    
        $trademark = new Trademark;
        $form = $this->createForm( TrademarkType::class, $trademark, array(
            'action' => $this->generateUrl('abo_trademark_admin_register'),
        ));
        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                
                $unique = $this->get('abo.uniqueness');
                $trademark->setFolder($unique->getUnique('ABOTrademarkBundle:Trademark','folder'));
                
                $image = $form->get('image')->getData();
                $image->setEntity('trademark');
                $image->setFolder($trademark->getFolder());
                $image->setImage($unique->nameImage($image->getFolder()));
                $image->setType('profile');
                $image->upload();
                $trademark->setImage($image);
                
                $imageTm = new ImageTrademark();
                $imageTm->setTrademark($trademark);
                $imageTm->setImage($image);
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($image);
                $em->persist($trademark);
                $em->persist($imageTm);
                $em->flush();
            
                return $this->redirect($this->generateUrl('admin_admin_add_trademark'));
            }
        }
    
        return $this->render('ABOTrademarkBundle:Admin:register.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    /**
     * @Route("/{slug}/edit")
     */
    public function settingAction($slug) {
    
        $trademark = $this->getDoctrine()->getRepository('ABOTrademarkBundle:Trademark')->findOneBy(array('slug' => $slug));
    
        return $this->render('ABOTrademarkBundle:Admin:setting.html.twig', array(
            'trademark' => $trademark,
        ));
    }
    
    /**
     * @Route("/{slug}/navigation", methods={"POST"})
     */
    public function navigationAction($trademark) {
        
        $arr_1 = $this->getDoctrine()->getRepository('ABOTrademarkBundle:Arrangement')->findBy(array('trademark'=>$trademark,'level' => 1));
        $arr_2 = $this->getDoctrine()->getRepository('ABOTrademarkBundle:Arrangement')->findBy(array('trademark'=>$trademark,'level' => 2));
        $categories = $this->getDoctrine()->getRepository('ABOTrademarkBundle:CategoryTrademark')->getCategories($trademark);
        
        $arrangements = array();
        foreach ($arr_1 as $value) {
            $arrangements[$value->getName()] = array($value);
        }
        foreach ($arr_2 as $value) {
            array_push($arrangements[$value->getParent()->getName()], $value);
        }
        
        return $this->render('ABOTrademarkBundle::navigation.html.twig', array(
            'arrangements' => $arrangements,
            'categories' => $categories,
            'trademark' => $trademark,
        ));
    }

    /**
     * @Route("/{slug}/features", methods={"POST"})
     */
    public function featureAction(Request $request, $slug) {
        
        $trademark = $this->getDoctrine()->getRepository('ABOTrademarkBundle:Trademark')->findOneBy(array('slug' => $slug));
        $catTm = $this->getDoctrine()->getRepository('ABOTrademarkBundle:CategoryTrademark')->getCategories($trademark);
        $categories = array();
        foreach ($catTm as $value) {
            array_push($categories, $value->getCategory()->getId());
        }
        $feature = new Feature;
        $form = $this->createForm( FeatureType::class, $feature, array(
            'categories' => $categories,
            'action' => $this->generateUrl('abo_trademark_admin_feature', array('slug'=>$slug)),
        ));
        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $image = $this->get('abo.file_uploader')->handleImage($form->get('image')->getData()
                    , $trademark->getFolder(), 'trademark', 'feature');
                if( $image ){
                    $feature->setImage($image);
                    $em->persist($image);
                    $imgTM = new ImageTrademark($trademark, $image);
                    $em->persist($imgTM);
                }
                $feature->setTrademark($trademark);
                $em->persist($feature);
                $em->flush();

                if( !empty($form->get('nameAr')->getData()) && !empty($form->get('descriptionAr')->getData()) ){

                    $feature->setName( $form->get('nameAr')->getData() );
                    $feature->setDescription( $form->get('descriptionAr')->getData() );
                    $feature->setTranslatableLocale('ar');
                    $em->persist($feature); $em->flush();
                }
                if( !empty($form->get('nameFr')->getData()) && !empty($form->get('descriptionFr')->getData()) ){

                    $feature->setName( $form->get('nameFr')->getData() );
                    $feature->setDescription( $form->get('descriptionFr')->getData() );
                    $feature->setTranslatableLocale('fr');
                    $em->persist($feature); $em->flush();
                }
                
                return $this->redirect($this->generateUrl('abo_trademark_admin_feature',array('slug' => $trademark->getSlug())));
            }
        }
        return $this->render('ABOTrademarkBundle:Admin:feature.html.twig', array(
            'trademark' => $trademark,
            'form' => $form->createView(),
            'feature'=>  $this->getDoctrine()->getRepository('ABOMainBundle:Feature')->findAllByLocale(13, $request->getLocale()),
            'locale' => $request->getLocale(),
        ));
    }

    /**
     * @Route("/{slug}/arrangements", methods={"POST"})
     */
    public function arrangementAction(Request $request, $slug) {
        
        $trademark = $this->getDoctrine()->getRepository('ABOTrademarkBundle:Trademark')->findOneBy(array('slug' => $slug));
        $catTm = $this->getDoctrine()->getRepository('ABOTrademarkBundle:CategoryTrademark')->getCategories($trademark);
        $categories = array();
        foreach ($catTm as $value) {
            array_push($categories, $value->getCategory()->getId());
        }
        $arrangement = new Arrangement();
        $form = $this->createForm( ArrangementType::class, $arrangement, array(
            'trademark' => $trademark,
            'categories' => $categories,
            'action' => $this->generateUrl('abo_trademark_admin_arrangement', array('slug' => $slug)),
        ));
        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $arrangement->setTrademark($trademark);
                $em->persist($arrangement);
                $em->flush();
                
                return $this->redirect($this->generateUrl('abo_trademark_admin_arrangement',array('slug' => $trademark->getSlug())));
            }
        }
        
        return $this->render('ABOTrademarkBundle:Admin:arrangement.html.twig', array(
            'trademark' => $trademark,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{slug}/categories", methods={"POST"})
     */
    public function setCategoriesAction(Request $request, $slug){

        $trademark = $this->getDoctrine()->getRepository('ABOTrademarkBundle:Trademark')->findOneBy(array('slug' => $slug));

        $catService = $this->get('abo.category');
        $form = $this->createForm( CategoryType::class, null, array(
            'categories' => $catService->getCats(),
            'action' => $this->generateUrl('abo_trademark_admin_setcategories', array('slug' => $slug)),
        ));

    	if ($request->getMethod() === 'POST') {
    		$form->handleRequest($request);
    		if ($form->isValid()) {

                $catService->trademark($form, $trademark);
    			return $this->redirect($this->generateUrl('abo_trademark_show_home', array('slug'=>$trademark->getSlug())));
    		}
    	}
    	
        $tmCategories = $this->getDoctrine()->getRepository('ABOTrademarkBundle:CategoryTrademark')
            ->getCategories($trademark);
        
        return $this->render('ABOTrademarkBundle:Admin:setCategories.html.twig', array(
            'trademark' => $trademark,
            'tmCategories' => $tmCategories,
        	'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{slug}/categories/{id}", methods={"POST"})
     */
    public function removeCategoryAction(Trademark $trademark, $id) {

        $translator = $this->get('translator');
        $em = $this->getDoctrine()->getManager();
        $catU = $em->getRepository('ABOTrademarkBundle:CategoryTrademark')
            ->findOneBy(array('trademark'=>$trademark,'id'=>$id));
        if($catU){
            $em->remove($catU);
            $em->flush();
            return new JsonResponse(array(
                'stat'=>'success',
                'title' => $translator->trans('category_setting_page.success_title'),
                'content'=>  '',
            ));
        }else{
            return new JsonResponse(array(
                'stat'=>'danger',
                'title' => $this->get('translator')->trans('category_setting_page.error_title'),
                'content'=>  $this->get('translator')->trans('category_setting_page.cat_user_unfound'),
            ));
        }
    }
}
