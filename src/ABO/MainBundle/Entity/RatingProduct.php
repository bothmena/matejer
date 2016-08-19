<?php

namespace ABO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * RatingProduct
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ABO\MainBundle\Entity\RatingProductRepository")
 */
class RatingProduct {
    
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
     * @ORM\ManyToOne(targetEntity="ABO\MainBundle\Entity\CategoryProduct")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categoryProduct;
    
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

        $start = 'matejer_review.' . $this->getCategoryProduct()->getCategory()->getSpecsClass(). '.';
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
     * Get value
     *
     * @param int $i
     * @return int
     */
    public function getValue($i){

        switch($i){
            case 1:
                return $this->getRate()->getValueOne();
            case 2:
                return $this->getRate()->getValueTwo();
            case 3:
                return $this->getRate()->getValueThree();
            case 4:
                return $this->getRate()->getValueFour();
            case 0:
                return $this->getRate()->getValue();
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
     * @return RatingProduct
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
     * @return RatingProduct
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
     * @return RatingProduct
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
     * @return RatingProduct
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
     * @return RatingProduct
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
     * @return RatingProduct
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
     * Set categoryProduct
     *
     * @param \ABO\MainBundle\Entity\CategoryProduct $categoryProduct
     *
     * @return RatingProduct
     */
    public function setCategoryProduct(\ABO\MainBundle\Entity\CategoryProduct $categoryProduct)
    {
        $this->categoryProduct = $categoryProduct;

        return $this;
    }

    /**
     * Get categoryProduct
     *
     * @return \ABO\MainBundle\Entity\CategoryProduct
     */
    public function getCategoryProduct()
    {
        return $this->categoryProduct;
    }
}
