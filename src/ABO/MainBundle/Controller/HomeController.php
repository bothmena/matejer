<?php

namespace ABO\MainBundle\Controller;

use ABO\MainBundle\Event\ABOMatejerEvents;
use ABO\MainBundle\Event\UserChangeLanguageEvent;
use ABO\MainBundle\Form\ContactUsType;
use ABO\MainBundle\Form\LanguageType;
use ABO\MainBundle\Form\MainSearchType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;


class HomeController extends Controller {

    /**
     * @Route("/{sent}", methods={"GET", "POST"}, requirements={"sent" = "_success|_error|_none"}, defaults={"sent" = "_none"}, host="matejer.local")
     * @Cache(public=false, maxage=0, smaxage=0)
     */
    public function homeAction( Request $request, $sent ) {

        $products = $this->getDoctrine()->getRepository('ABOMainBundle:CategoryProduct')->whatsNew();
        $form = $this->createForm( ContactUsType::class, null, array(
            'action' => $this->generateUrl( 'abo_main_home_home' ),
            'method' => 'POST',
        ));
        
        if($request->getMethod() === 'POST'){

            $form->handleRequest($request);
            if($form->isValid()){

                $mailer = $this->get('abo.mail');
                $mailer->contactUs( $form->get('email')->getData(), $form->get('name')->getData(),
                    $form->get('subject')->getData(), $form->get('message')->getData() );
                return $this->redirectToRoute('abo_main_home_home', array('sent' => '_success'));
            }else{
                return $this->redirectToRoute('abo_main_home_home', array('sent' => '_error'));
            }
        }

        return $this->render('@ABOMain/Home/home.html.twig', array(
            'products'=>$products,
            'sent' => $sent,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/search-form", name="main_home_mainsearch", methods={"GET", "POST"})
     */
    public function mainSearchAction(){

        $form = $this->createForm(MainSearchType::class, null, array(
            'action' => $this->generateUrl('main_home_searchsubmit'),
            'method' => 'POST',
        ));
        return $this->render('@ABOMain/Home/mainSearch.html.twig', array(
            'form'=>$form->createView(),
        ));
    }

    /**
     * @Route("/search-form-submit", name="main_home_searchsubmit", methods={"POST"})
     */
    public function searchSubmitAction(Request $request){

        $form = $this->createForm(MainSearchType::class);

        if($request->getMethod() === 'POST'){
            $form->handleRequest($request);
            if ($form->isValid()){

                $query = $form->get('search')->getData();
                return $this->redirectToRoute('abo_main_gallery_gallery', array('search'=>$query));
            }
        }
        else
            return $this->redirectToRoute('abo_main_gallery_gallery');
    }

    /**
     * @Route("/change-language-main", name="main_home_language", methods={"GET", "POST"})
     */
    public function mainLanguageAction(Request $request){

        $form = $this->createForm( LanguageType::class, null, array(
            'action' => $this->generateUrl('main_home_language'),
            'locale' => $request->getLocale(),
        ) );

        if( $request->getMethod() === 'POST' ){
            $form->handleRequest($request);
            if($form->isValid()) {
                return $this->changeLocale($request, $form);
            }
        }

        return $this->render('@ABOMain/Home/mainLanguage.html.twig', array(
            'form'=>$form->createView(),
        ));

    }
    /**
     * @Route("/change-language-dash", name="dash_home_language", methods={"GET", "POST"})
     */
    public function dashLanguageAction(Request $request){

        $form = $this->createForm( LanguageType::class, null, array(
            'action' => $this->generateUrl('dash_home_language'),
            'locale' => $request->getLocale(),
        ) );

        if( $request->getMethod() === 'POST' ){
            $form->handleRequest($request);
            if($form->isValid()) {
                return $this->changeLocale($request, $form);
            }
        }

        return $this->render('@ABOMain/Home/dashLanguage.html.twig', array(
            'form'=>$form->createView(),
        ));

    }

    private function changeLocale(Request $request, Form $form){

        $user = $this->getUser();
        if( $user ){
            $user->setLanguage( $form->get('language')->getData() );
            $this->getDoctrine()->getManager()->flush();
        }
        $event = new UserChangeLanguageEvent( $user, $form->get('language')->getData() );
        $this->get('event_dispatcher')->dispatch(ABOMatejerEvents::USER_CHANGE_LANGUAGE, $event);

        return $this->redirect($request->headers->get('referer'));
    }
}
