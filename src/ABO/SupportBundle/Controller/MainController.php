<?php

namespace ABO\SupportBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("", methods={"GET"})
 */
class MainController extends Controller {
    
    /**
     * @Route("/home")
     */
    public function homeAction() {
        
        
        return $this->render('ABOSupportBundle:Main:Home.html.twig', array(
            
        ));
    }

    /**
     * @Route("/help")
     */
    public function helpAction() {
        
        
        return $this->render('ABOSupportBundle:Main:help.html.twig', array(
            
        ));
    }

    /**
     * @Route("/guide")
     */
    public function guideAction() {
        
        
        return $this->render('ABOSupportBundle:Main:guide.html.twig', array(
            
        ));
    }

    /**
     * @Route("/about-us")
     */
    public function aboutUsAction() {
        
        
        return $this->render('ABOSupportBundle:Main:story.html.twig', array(
            
        ));
    }

}
