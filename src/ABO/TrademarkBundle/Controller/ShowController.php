<?php

namespace ABO\TrademarkBundle\Controller;

use ABO\TrademarkBundle\Entity\Trademark;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 * @Route("/{slug}", methods={"GET"})
 * @Cache(public=false, maxage="0", smaxage="0")
 */
class ShowController extends Controller {
    
    /**
     * @Route("")
     */
    public function homeAction($slug) {
        
        $user = $this->getUser();
        $trademark = $this->getDoctrine()->getRepository('ABOTrademarkBundle:Trademark')->findOneBySlug($slug);
        
        return $this->render('ABOTrademarkBundle:Show:home.html.twig', array(
            'user' => $user,
            'trademark' => $trademark,
        ));
    }

    /**
     * @Route("/about")
     */
    public function aboutAction(Trademark $trademark) {
        
        $eFeatures = $this->getDoctrine()->getRepository('ABOMainBundle:Feature')->findBy(array('trademark' => $trademark));
        
        $features = array();
        
        foreach ($eFeatures as $feature){
            /* @var $feature \ABO\MainBundle\Entity\Feature */
            if( isset($features[$feature->getCategory()->getTranslatable()]) ){
                array_push($features[$feature->getCategory()->getTranslatable()], $feature);
            }else{
                $features[$feature->getCategory()->getTranslatable()] = array($feature);
            }
        }
        
        return $this->render('ABOTrademarkBundle:Show:about.html.twig', array(
            'trademark' => $trademark,
            'features' => $features,
        ));
    }

    /**
     * @Route("/reviews")
     */
    public function reviewsAction($slug) {
        
        $user = $this->getUser();
        $trademark = $this->getDoctrine()->getRepository('ABOTrademarkBundle:Trademark')->findOneBy(array('slug' => $slug));
        
        return $this->render('ABOTrademarkBundle:Show:reviews.html.twig', array(
            'user' => $user,
            'trademark' => $trademark,
        ));
    }
}
