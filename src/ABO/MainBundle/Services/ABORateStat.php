<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ABO\MainBundle\Services;

use ABO\MainBundle\Entity\Rate;
use ABO\MainBundle\Entity\RateStat;
use Doctrine\ORM\EntityManager;

class ABORateStat{
    
    private $em;

    public function __construct(EntityManager $em) {
        
        $this->em = $em;
    }
    
    public function updateRateStat($rateProdOrShop, RateStat $rateStat, array $oldRate) {
        
        if(!empty($oldRate))
            $this->minusRating ($oldRate, $rateStat);
        $this->plusRating($rateProdOrShop->getRate(), $rateStat);

        $this->em->persist($rateProdOrShop);
        $this->em->persist($rateStat);
        $this->em->flush();
    }

    private function plusRating(Rate $rate, RateStat $rateStat) {
        
        $rateStat->plusValue($rate->getValue());
        
        if($rate->getValueOne() > 0)
            $rateStat->plusValueOne($rate->getValueOne());
        
        if($rate->getValueTwo() > 0)
            $rateStat->plusValueTwo($rate->getValueTwo());
        
        if($rate->getValueThree() > 0)
            $rateStat->plusValueThree($rate->getValueThree());
        
        if($rate->getValueFour() > 0)
            $rateStat->plusValueFour($rate->getValueFour());
    }

    private function minusRating(array $rate, RateStat $rateStat) {
        
        $rateStat->minusValue($rate['value']);
        
        if($rate['valueOne'] > 0)
            $rateStat->minusValueOne($rate['valueOne']);
        
        if($rate['valueTwo'] > 0)
            $rateStat->minusValueTwo($rate['valueTwo']);
        
        if($rate['valueThree'] > 0)
            $rateStat->minusValueThree($rate['valueThree']);
        
        if($rate['valueFour'] > 0)
            $rateStat->minusValueFour($rate['valueFour']);
    }
}
