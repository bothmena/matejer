<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ABO\MainBundle\Services;

use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Util\TokenGenerator;

class ABOUniqueness {
    
    private $em;
    private $tGenerator;
    
    private $alphaNumeric = array(
        'A', 'a', 'B', 'b', 'C', 'c', 'D', 'd', 'E', 'e', 'F', 'f', 'G', 'g', 'H', 'h', 'I', 'i','J', 'j', 
        'K', 'k', 'L', 'l', 'M', 'm', 'N', 'n', 'O', 'o', 'P', 'p', 'Q', 'q', 'R', 'r', 'S', 's', 'T', 't', 
        'U', 'u', 'V', 'v', 'W', 'w', 'X', 'x', 'Y', 'y', 'Z', 'z', '0', '1', '2', '3', '4', '5', '6', '7', 
        '8', '9', '-', '_'
    );

    public function __construct(EntityManager $em, TokenGenerator $tGenerator) {
        
        $this->em = $em;
        $this->tGenerator = $tGenerator;
    }
    
    public function isAvailable($entityName,$field,$value) {
        
        $item = $this->em->getRepository($entityName)->findOneBy(array($field=>$value));
        if($item)
            return FALSE;
        else 
            return true;
    }
    
    private function isNameAvailable($folder,$image) {
        
        $item = $this->em->getRepository('ABOMainBundle:Image')->findOneBy(array('folder'=>$folder,'image'=>$image));
        if($item)
            return FALSE;
        else 
            return true;
    }
    
    public function getUnique($entityName,$field){

        do {
            $unique = $this->generateUnique();
        } while (!$this->isAvailable($entityName, $field, $unique));
        
        return $unique;
    }
    
    public function getUniqueToken($entityName,$field){

        do {
            $token = $this->tGenerator->generateToken();
        } while (!$this->isAvailable($entityName, $field, $token));
        
        return $token;
    }
    
    public function nameImage($folder, $ext){

        do {
            $image = $this->generateUnique().'.'.$ext ;
        } while (!$this->isNameAvailable($folder,$image));
        
        return $image;
    }
    
    private function generateUnique(){
        
        $unique = '';
        $length = rand(11,20);
        $arrLength = count($this->alphaNumeric) - 1;
        
        for($i = 0; $i < $length; $i++){
            $unique .= $this->alphaNumeric[rand(0,$arrLength)];
        }
        return $unique;
    }
}
