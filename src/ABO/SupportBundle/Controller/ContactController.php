<?php

namespace ABO\SupportBundle\Controller;

use ABO\MainBundle\Form\ContactUsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller {
    
    /**
     * @Route("/contact-us", methods={"GET"}, name="matejer_support_contact_us")
     */
    public function contactAction() {

        return $this->render('@ABOSupport/Contact/contact.html.twig');
    }

    /**
     * @Route("/contact-us-form", methods={"GET", "POST"}, name="matejer_support_contact_form")
     */
    public function contactFormAction(Request $request) {

        $form = $this->createForm( ContactUsType::class, null, array(
            'action' => $this->generateUrl( 'matejer_support_contact_form' ),
            'method' => 'POST',
        ) );

        if($request->getMethod() === 'POST'){

            $form->handleRequest($request);
            if($form->isValid()){
                return $this->redirectToRoute('abo_main_gallery_gallery');
            }
        }

        return $this->render('@ABOSupport/Contact/contactForm.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}
