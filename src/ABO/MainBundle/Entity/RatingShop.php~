<?php

namespace ABO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * RatingShop
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ABO\MainBundle\Entity\RatingShopRepository")
 */
class RatingShop
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
    * @ORM\ManyToOne(targetEntity="ABO\MainBundle\Entity\Rate", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
    */
    private $rate;
    
    /**
    * @ORM\ManyToOne(targetEntity="ABO\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
    */
    private $user;

    /**
    * @ORM\ManyToOne(targetEntity="ABO\ShopBundle\Entity\Shop")
     * @ORM\JoinColumn(nullable=false)
    */
    private $shop;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="likeNb", type="integer", options={"unsigned"=true})
     */
    private $likeNb;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="dislikeNb", type="integer", options={"unsigned"=true})
     */
    private $dislikeNb;

    /**
     * @var boolean
     *
     * @ORM\Column(name="critical", type="boolean")
     * @Assert\Type("bool")
     */
    private $critical;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    public function __construct() {
        
        $this->date = new \DateTime;
        $this->likeNb = 0;
        $this->dislikeNb = 0;
        $this->critical = FALSE;
    }

    /**
     * Get transValue
     *
     * @param int $i
     * @return string
     */
    public function getTransValue($i){

        switch($i){
            case 0:
                return 'matejer_review.shop.value';
            case 1:
                return 'matejer_review.shop.valueOne';
            case 2:
                return 'matejer_review.shop.valueTwo';
            case 3:
                return 'matejer_review.shop.valueThree';
            case 4:
                return 'matejer_review.shop.valueFour';
            default:
                return '';
        }
    }

    /**
     * Get value
     *
     * @param int $i
     * @return int
     */
    public function getValue($i){

        switch($i){
            case 0:
                return $this->getRate()->getValue();
            case 1:
                return $this->getRate()->getValueOne();
            case 2:
                return $this->getRate()->getValueTwo();
            case 3:
                return $this->getRate()->getValueThree();
            case 4:
                return $this->getRate()->getValueFour();
            default:
                return 0;
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
     * Set likeNb
     *
     * @param integer $likeNb
     *
     * @return RatingShop
     */
    public function setLikeNb($likeNb)
    {
        $this->likeNb = $likeNb;

        return $this;
    }

    /**
     * Get likeNb
     *
     * @return integer
     */
    public function getLikeNb()
    {
        return $this->likeNb;
    }

    /**
     * Set dislikeNb
     *
     * @param integer $dislikeNb
     *
     * @return RatingShop
     */
    public function setDislikeNb($dislikeNb)
    {
        $this->dislikeNb = $dislikeNb;

        return $this;
    }

    /**
     * Get dislikeNb
     *
     * @return integer
     */
    public function getDislikeNb()
    {
        return $this->dislikeNb;
    }

    /**
     * Set critical
     *
     * @param boolean $critical
     *
     * @return RatingShop
     */
    public function setCritical($critical)
    {
        $this->critical = $critical;

        return $this;
    }

    /**
     * Get critical
     *
     * @return boolean
     */
    public function getCritical()
    {
        return $this->critical;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return RatingShop
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set rate
     *
     * @param \ABO\MainBundle\Entity\Rate $rate
     *
     * @return RatingShop
     */
    public function setRate(\ABO\MainBundle\Entity\Rate $rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return \ABO\MainBundle\Entity\Rate
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set user
     *
     * @param \ABO\UserBundle\Entity\User $user
     *
     * @return RatingShop
     */
    public function setUser(\ABO\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \ABO\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set shop
     *
     * @param \ABO\ShopBundle\Entity\Shop $shop
     *
     * @return RatingShop
     */
    public function setShop(\ABO\ShopBundle\Entity\Shop $shop)
    {
        $this->shop = $shop;

        return $this;
    }

    /**
     * Get shop
     *
     * @return \ABO\ShopBundle\Entity\Shop
     */
    public function getShop()
    {
        return $this->shop;
    }
}
