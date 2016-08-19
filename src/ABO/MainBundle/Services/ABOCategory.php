<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ABO\MainBundle\Services;

use ABO\MainBundle\Entity\CategoryUser;
use ABO\ShopBundle\Entity\CategoryShop;
use ABO\ShopBundle\Entity\Collection;
use ABO\ShopBundle\Entity\Shop;
use ABO\TrademarkBundle\Entity\CategoryTrademark;
use ABO\TrademarkBundle\Entity\Trademark;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Symfony\Component\Security\Core\User\UserInterface;

class ABOCategory {
    
    private $em;
    
    public function __construct(EntityManager $manager) {
        
        $this->em = $manager;
    }

    public function getCats(){

        $categories = $this->em->getRepository('ABOMainBundle:Category')->findByLevel(2);
        $cats = [];
        foreach ($categories as $category) {
            if(!empty($cats[$category->getParentName()]))
                array_push ($cats[$category->getParentName()], $category);
            else
                $cats[$category->getParentName()] = [$category];
        }
        return $cats;
    }

    public function shop(Form $form, Shop $shop) {

        $shopCats = $this->em->getRepository('ABOShopBundle:CategoryShop')->getCategories($shop);
        $shopCats = $this->arrayCats($shopCats);

        foreach ($form->getData() as $data){
            if( !$data->isEmpty() ){
                foreach ($data as $category){
                    $catS = $this->em->getRepository('ABOMainBundle:Category')
                        ->getCatsByParent($category);
                    foreach ( $catS as $cat ){
                        if( !in_array($cat, $shopCats) ){
                            $catShops = new CategoryShop( $cat, $shop );
                            $this->em->persist($catShops);
                        }
                    }
                }
            }
        }
        $this->em->flush();
    }

    public function trademark(Form $form, Trademark $trademark) {

        $tmCats = $this->em->getRepository('ABOTrademarkBundle:CategoryTrademark')->getCategories($trademark);
        $tmCats = $this->arrayCats($tmCats);

        foreach ($form->getData() as $data){
            if( !$data->isEmpty() ){
                foreach ($data as $category){
                    $childrenCats = $this->em->getRepository('ABOMainBundle:Category')
                        ->getCatsByParent($category);
                    foreach ( $childrenCats as $shildCat ){
                        if( !in_array($shildCat, $tmCats) ){
                            $catTms = new CategoryTrademark( $shildCat, $trademark );
                            $this->em->persist($catTms);
                        }
                    }
                }
            }
        }
        $this->em->flush();
    }

    public function user(Form $form, UserInterface $user) {

        $userCats = $this->em->getRepository('ABOMainBundle:CategoryUser')->userCategories($user);
        $userCats = $this->arrayCats($userCats);

        foreach ($form->getData() as $data){
            if( !$data->isEmpty() ){
                foreach ($data as $category){
                    $childrenCats = $this->em->getRepository('ABOMainBundle:Category')
                        ->getCatsByParent($category);
                    foreach ( $childrenCats as $shildCat ){
                        if( !in_array($shildCat, $userCats) ){
                            $catUsers = new CategoryUser( $shildCat, $user );
                            $this->em->persist($catUsers);
                        }
                    }
                }
            }
        }
        $this->em->flush();
    }

    public function catsToArray(array $categories){

        $cats = [];
        foreach ($categories as $category){
            if(empty($cats[$category->getCategory()->getParentName()]))
                $cats[$category->getCategory()->getParentName()] = [$category];
            else
                array_push($cats[$category->getCategory()->getParentName()], $category);
        }
        return $cats;
    }

    public function colsToArray(array $collections){

        $cols = [];
        foreach ($collections as $col){
            /**
             * @var $col Collection
             */
            if($col->getLevel() === 1){
                $cols[$col->getSlug()] = [ 'children'=>[], 'name'=>$col->getName(), 'productNb'=>$col->getProductNb(), 'parent'=>$col->getAnyParent() ];
            }
            else if($col->getLevel() === 2){
                $arr = array( 'children'=>[], 'name'=>$col->getName(), 'productNb'=>$col->getProductNb(), 'parent'=>$col->getAnyParent() );
                $cols[ $col->getParent()->getSlug() ]['children'][$col->getSlug()] = $arr;
            }
            else if($col->getLevel() === 3){
                $arr = array( 'name'=>$col->getName(), 'productNb'=>$col->getProductNb() );
                $cols[ $col->getParent()->getParent()->getSlug() ]['children'][ $col->getParent()->getSlug() ]['children'][$col->getSlug()] = $arr;
            }
        }
        return $cols;
    }

    private function arrayCats($catEntities){
        $arr = [];
        foreach ( $catEntities as $catEntity ){
            array_push( $arr, $catEntity->getCategory() );
        }
        return $arr;
    }
    
    public function getName() {
        
        return 'ABOCategory';
    }
}
