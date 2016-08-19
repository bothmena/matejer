<?php

namespace ABO\AdminBundle\Controller;

use ABO\MainBundle\Entity\Image;
use ABO\TrademarkBundle\Entity\Trademark;
use ABO\TrademarkBundle\Form\TrademarkType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller {

    /**
     * @Route("/{url}", name="remove_trailing_slash", requirements={"url" = ".*\/$"})
     */
    public function removeTrailingSlashAction(Request $request) {

        $pathInfo = $request->getPathInfo();
        $requestUri = $request->getRequestUri();

        $url = str_replace($pathInfo, rtrim($pathInfo, ' /'), $requestUri);

        return $this->redirect($url, 301);
    }
    
    /**
     * @Route("/admin/dashboard", host="matejer.local")
     * @Security("is_granted('ROLE_ADMIN')")
     * @Template
     */
    public function dashboardAction() {}

    /**
     * @Route("/admin/new-TM", methods={"GET", "POST"}, host="matejer.local")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function addTrademarkAction(Request $request) {
        
        $trademark = new Trademark();
        $form = $this->createForm(TrademarkType::class, $trademark, array(
            'action' => $this->generateUrl('abo_admin_admin_addtrademark'),
        ));
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                
                $unique = $this->get('abo.uniqueness');
                $trademark->setFolder($unique->getUnique('ABOTrademarkBundle:Trademark','folder'));
                
                $image = $form->get('image')->getData();
                $image->setEntity('trademark');
                $image->setFolder($trademark->getFolder());
                /** @var Image $image */
                $image->setImage( $unique->nameImage( $image->getFolder(), $image->getFileExt() ) );
                $image->setType('profile');
                $image->upload();
                $trademark->setImage($image);
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($image);
                $em->persist($trademark);
                $em->flush();
            
                return $this->redirect($this->generateUrl('abo_admin_admin_addtrademark'));
            }
        }
        
        return $this->render('ABOAdminBundle:Admin:addTrademark.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/admin/all-TMs", host="matejer.local")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function allTrademarkAction() {
        
        $tm_repo = $this->getDoctrine()->getRepository('ABOTrademarkBundle:Trademark');
        $all = $tm_repo->findAll();
        
        return $this->render('ABOAdminBundle:Admin:allTrademark.html.twig', array(
           'all' => $all,
        ));
    }

    /**
     * @Route("/admin/all-shops", host="matejer.local")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function allShopAction() {
        
        
        return $this->render('ABOAdminBundle:Admin:allShop.html.twig', array(
           
        ));
    }

    /**
     * @Route("/admin/all-users", host="matejer.local")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function allUserAction() {
        
        
        return $this->render('ABOAdminBundle:Admin:allUser.html.twig', array());
    }

    /**
     * @Route("/admin/all-products", host="matejer.local")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function allProductAction() {
        
        
        return $this->render('ABOAdminBundle:Admin:allProduct.html.twig', array(
           
        ));
    }

}
