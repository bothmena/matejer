<?php

namespace ABO\SupportBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("", methods={"GET"})
 */
class FAQController extends Controller {

    /**
     * @Route("/ask-question", methods={"GET"}, name="support_faq_ask")
     */
    public function askQuestionAction() {

        return $this->render('ABOSupportBundle:FAQ:askQuestion.html.twig', array(

        ));
    }

    /**
     * @Route("/FAQ", methods={"GET"}, name="support_faq_home")
     */
    public function homeAction() {

        return $this->render('ABOSupportBundle:FAQ:home.html.twig', array(

        ));
    }
}
