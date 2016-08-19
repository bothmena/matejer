<?php

namespace ABO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RateStat
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class RateStat
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="decimal", precision=4, scale=2)
     */
    private $value;

    /**
     * @var string
     *
     * @ORM\Column(name="valueOne", type="decimal", precision=4, scale=2)
     */
    private $valueOne;

    /**
     * @var string
     *
     * @ORM\Column(name="valueTwo", type="decimal", precision=4, scale=2)
     */
    private $valueTwo;

    /**
     * @var string
     *
     * @ORM\Column(name="valueThree", type="decimal", precision=4, scale=2)
     */
    private $valueThree;

    /**
     * @var string
     *
     * @ORM\Column(name="valueFour", type="decimal", precision=4, scale=2)
     */
    private $valueFour;

    /**
     * @var integer
     *
     * @ORM\Column(name="valueNb", type="integer", options={"unsigned"=true})
     */
    private $valueNb;

    /**
     * @var integer
     *
     * @ORM\Column(name="valueOneNb", type="integer", options={"unsigned"=true})
     */
    private $valueOneNb;

    /**
     * @var integer
     *
     * @ORM\Column(name="valueTwoNb", type="integer", options={"unsigned"=true})
     */
    private $valueTwoNb;

    /**
     * @var integer
     *
     * @ORM\Column(name="valueThreeNb", type="integer", options={"unsigned"=true})
     */
    private $valueThreeNb;

    /**
     * @var integer
     *
     * @ORM\Column(name="valueFourNb", type="integer", options={"unsigned"=true})
     */
    private $valueFourNb;

    public function __construct() {
        
        $this->value = 0;
        $this->valueNb = 0;
        $this->valueOne = 0;
        $this->valueOneNb = 0;
        $this->valueTwo = 0;
        $this->valueTwoNb = 0;
        $this->valueThree = 0;
        $this->valueThreeNb = 0;
        $this->valueFour = 0;
        $this->valueFourNb = 0;
    }

    /**
     * Get transValue
     *
     * @param int $i
     * @return string
     */
    public function getTransValue($i, $specsClass){

        $start = 'matejer_review.' .$specsClass. '.';
        switch($i){
            case 0:
                return $start.'value';
            case 1:
                return $start.'valueOne';
            case 2:
                return $start.'valueTwo';
            case 3:
                return $start.'valueThree';
            case 4:
                return $start.'valueFour';
        }
    }

    /**
     * Get valueSwitch
     *
     * @param int $i
     * @return int
     */
    public function valueSwitch($i){

        switch($i){
            case 1:
                return $this->getValueOne();
            case 2:
                return $this->getValueTwo();
            case 3:
                return $this->getValueThree();
            case 4:
                return $this->getValueFour();
            case 0:
                return $this->getValue();
        }
    }

    /**
     * Get valueNbr
     *
     * @param int $i
     * @return int
     */
    public function valueNbr($i){

        switch($i){
            case 0:
                return $this->getValueNb();
            case 1:
                return $this->getValueOneNb();
            case 2:
                return $this->getValueTwoNb();
            case 3:
                return $this->getValueThreeNb();
            case 4:
                return $this->getValueFourNb();
        }
    }
    
    public function plusValue($newValue) {
        
        $val = $this->value;
        $nb = $this->valueNb;
        
        $this->value = ($val * $nb + $newValue) / ($nb + 1);
        $this->valueNb = $this->valueNb + 1;
    }
    
    public function minusValue($oldValue) {
        
        $val = $this->value;
        $nb = $this->valueNb;
        if($nb < 2){
            $this->value = 0;
            $this->valueNb = 0;
        }else{
            $this->value = ($val * $nb - $oldValue) / ($nb - 1);
            $this->valueNb = $this->valueNb - 1;
        }
    }
    
    public function plusValueOne($newValue) {
        
        $val = $this->valueOne;
        $nb = $this->valueOneNb;
        
        $this->valueOne = ($val * $nb + $newValue) / ($nb + 1);
        $this->valueOneNb = $this->valueOneNb + 1;
    }
    
    public function minusValueOne($oldValue) {
        
        $val = $this->valueOne;
        $nb = $this->valueOneNb;
        
        if($nb < 2){
            $this->valueOne = 0;
            $this->valueOneNb = 0;
        }else{
            $this->valueOne = ($val * $nb - $oldValue) / ($nb - 1);
            $this->valueOneNb = $this->valueOneNb - 1;
        }
    }
    
    public function plusValueTwo($newValue) {
        
        $val = $this->valueTwo;
        $nb = $this->valueTwoNb;
        
        $this->valueTwo = ($val * $nb + $newValue) / ($nb + 1);
        $this->valueTwoNb = $this->valueTwoNb + 1;
    }
    
    public function minusValueTwo($oldValue) {
        
        $val = $this->valueTwo;
        $nb = $this->valueTwoNb;
        
        if($nb < 2){
            $this->valueTwo = 0;
            $this->valueTwoNb = 0;
        }else{
            $this->valueTwo = ($val * $nb - $oldValue) / ($nb - 1);
            $this->valueTwoNb = $this->valueTwoNb - 1;
        }
    }
    
    public function plusValueThree($newValue) {
        
        $val = $this->valueThree;
        $nb = $this->valueThreeNb;
        
        $this->valueThree = ($val * $nb + $newValue) / ($nb + 1);
        $this->valueThreeNb = $this->valueThreeNb + 1;
    }
    
    public function minusValueThree($oldValue) {
        
        $val = $this->valueThree;
        $nb = $this->valueThreeNb;
        
        if($nb < 2){
            $this->valueThree = 0;
            $this->valueThreeNb = 0;
        }else{
            $this->valueThree = ($val * $nb - $oldValue) / ($nb - 1);
            $this->valueThreeNb = $this->valueThreeNb - 1;
        }
    }
    
    public function plusValueFour($newValue) {
        
        $val = $this->valueFour;
        $nb = $this->valueFourNb;
        
        $this->valueFour = ($val * $nb + $newValue) / ($nb + 1);
        $this->valueFourNb = $this->valueFourNb + 1;
    }
    
    public function minusValueFour($oldValue) {
        
        $val = $this->valueFour;
        $nb = $this->valueFourNb;
        
        if($nb < 2){
            $this->valueFour = 0;
            $this->valueFourNb = 0;
        }else{
            $this->valueFour = ($val * $nb - $oldValue) / ($nb - 1);
            $this->valueFourNb = $this->valueFourNb - 1;
        }
    }
    
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return RateStat
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set valueOne
     *
     * @param string $valueOne
     *
     * @return RateStat
     */
    public function setValueOne($valueOne)
    {
        $this->valueOne = $valueOne;

        return $this;
    }

    /**
     * Get valueOne
     *
     * @return string
     */
    public function getValueOne()
    {
        return $this->valueOne;
    }

    /**
     * Set valueTwo
     *
     * @param string $valueTwo
     *
     * @return RateStat
     */
    public function setValueTwo($valueTwo)
    {
        $this->valueTwo = $valueTwo;

        return $this;
    }

    /**
     * Get valueTwo
     *
     * @return string
     */
    public function getValueTwo()
    {
        return $this->valueTwo;
    }

    /**
     * Set valueThree
     *
     * @param string $valueThree
     *
     * @return RateStat
     */
    public function setValueThree($valueThree)
    {
        $this->valueThree = $valueThree;

        return $this;
    }

    /**
     * Get valueThree
     *
     * @return string
     */
    public function getValueThree()
    {
        return $this->valueThree;
    }

    /**
     * Set valueFour
     *
     * @param string $valueFour
     *
     * @return RateStat
     */
    public function setValueFour($valueFour)
    {
        $this->valueFour = $valueFour;

        return $this;
    }

    /**
     * Get valueFour
     *
     * @return string
     */
    public function getValueFour()
    {
        return $this->valueFour;
    }

    /**
     * Set valueNb
     *
     * @param integer $valueNb
     *
     * @return RateStat
     */
    public function setValueNb($valueNb)
    {
        $this->valueNb = $valueNb;

        return $this;
    }

    /**
     * Get valueNb
     *
     * @return integer
     */
    public function getValueNb()
    {
        return $this->valueNb;
    }

    /**
     * Set valueOneNb
     *
     * @param integer $valueOneNb
     *
     * @return RateStat
     */
    public function setValueOneNb($valueOneNb)
    {
        $this->valueOneNb = $valueOneNb;

        return $this;
    }

    /**
     * Get valueOneNb
     *
     * @return integer
     */
    public function getValueOneNb()
    {
        return $this->valueOneNb;
    }

    /**
     * Set valueThreeNb
     *
     * @param integer $valueThreeNb
     *
     * @return RateStat
     */
    public function setValueThreeNb($valueThreeNb)
    {
        $this->valueThreeNb = $valueThreeNb;

        return $this;
    }

    /**
     * Get valueThreeNb
     *
     * @return integer
     */
    public function getValueThreeNb()
    {
        return $this->valueThreeNb;
    }

    /**
     * Set valueTwoNb
     *
     * @param integer $valueTwoNb
     *
     * @return RateStat
     */
    public function setValueTwoNb($valueTwoNb)
    {
        $this->valueTwoNb = $valueTwoNb;

        return $this;
    }

    /**
     * Get valueTwoNb
     *
     * @return integer
     */
    public function getValueTwoNb()
    {
        return $this->valueTwoNb;
    }

    /**
     * Set valueFourNb
     *
     * @param integer $valueFourNb
     *
     * @return RateStat
     */
    public function setValueFourNb($valueFourNb)
    {
        $this->valueFourNb = $valueFourNb;

        return $this;
    }

    /**
     * Get valueFourNb
     *
     * @return integer
     */
    public function getValueFourNb()
    {
        return $this->valueFourNb;
    }
}
