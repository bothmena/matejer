<?php

namespace ABO\MainBundle\Event;

use ABO\MainBundle\Entity\CategoryProduct;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Form\Form;

class ValidSpecificationSubmissionEvent extends Event {

    private $categoryProduct;
    private $form;


    public function __construct(CategoryProduct $catProd, Form $form){
        
        $this->categoryProduct = $catProd;
        $this->form = $form;
    }
    
    /**
     * Get categoryProduct
     *
     * @return \ABO\MainBundle\Entity\CategoryProduct
     */
    public function getCategoryProduct() {
        
        return $this->categoryProduct;
    }
    
    /**
     * Get form
     *
     * @return \Symfony\Component\Form\Form
     */
    public function getForm() {
        
        return $this->form;
    }
}
