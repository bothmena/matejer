<?php

namespace ABO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategoryProduct
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ABO\MainBundle\Entity\CategoryProductRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class CategoryProduct {
    

    /**
     * @ORM\PrePersist
     */
    public function markSpecsClass(){
    
        if($this->trademark)
            $this->product->setMark('');
        $this->product->checkReference();
        $this->generalSpecs->setSpecsClass($this->category->getSpecsClass());
    }
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="ABO\MainBundle\Entity\Product", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;
    
    /**
     * @ORM\ManyToOne(targetEntity="ABO\MainBundle\Entity\Category")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;
    
    /**
     * @ORM\OneToOne(targetEntity="ABO\MainBundle\Entity\GeneralSpec", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $generalSpecs;
    
    /**
     * @ORM\ManyToOne(targetEntity="ABO\TrademarkBundle\Entity\Trademark")
     */
    private $trademark;
    
    /**
     * @ORM\ManyToOne(targetEntity="ABO\TrademarkBundle\Entity\Arrangement")
     */
    private $arrangement;
    
    /**
     * @ORM\ManyToOne(targetEntity="ABO\ShopBundle\Entity\Shop")
     */
    private $shop;
    
    /**
     * @ORM\OneToOne(targetEntity="ABO\MainBundle\Entity\RateStat",cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $rateStat;
    
    /**
     * @ORM\ManyToOne(targetEntity="ABO\MainBundle\Entity\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $image;

    /**
     * @var boolean
     *
     * @ORM\Column(name="anyParent", type="boolean")
     */
    private $anyParent;

    /**
     * @ORM\ManyToOne(targetEntity="ABO\MainBundle\Entity\CategoryProduct")
     */
    private $parent;


    /**
     * Constructor
     */
    public function __construct() {
        
        $this->rateStat = new RateStat();
        $this->product = new Product();
        $this->anyParent = false;
    }
    
    /**
     * Get fullName
     *
     * @return string
     */
    public function getFullName() {
        
        if($this->trademark)
            $name = $this->trademark->getName().' - ';
        else
            $name = $this->product->getMark().' - ';
        
        if( empty( $this->product->getName() ) )
            return $name.$this->product->getReference();
        else
            return $name.$this->product->getName();
    }

    /**
     * Get brand
     *
     * @return string
     */
    public function getBrand() {

        if($this->trademark !== null)
            return $this->trademark->getName();
        else
            return $this->product->getMark();
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
     * Set product
     *
     * @param \ABO\MainBundle\Entity\Product $product
     *
     * @return CategoryProduct
     */
    public function setProduct(\ABO\MainBundle\Entity\Product $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \ABO\MainBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set category
     *
     * @param \ABO\MainBundle\Entity\Category $category
     *
     * @return CategoryProduct
     */
    public function setCategory(\ABO\MainBundle\Entity\Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \ABO\MainBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set generalSpecs
     *
     * @param \ABO\MainBundle\Entity\GeneralSpec $generalSpecs
     *
     * @return CategoryProduct
     */
    public function setGeneralSpecs(\ABO\MainBundle\Entity\GeneralSpec $generalSpecs)
    {
        $this->generalSpecs = $generalSpecs;

        return $this;
    }

    /**
     * Get generalSpecs
     *
     * @return \ABO\MainBundle\Entity\GeneralSpec
     */
    public function getGeneralSpecs()
    {
        return $this->generalSpecs;
    }

    /**
     * Set trademark
     *
     * @param \ABO\TrademarkBundle\Entity\Trademark $trademark
     *
     * @return CategoryProduct
     */
    public function setTrademark(\ABO\TrademarkBundle\Entity\Trademark $trademark = null)
    {
        $this->trademark = $trademark;

        return $this;
    }

    /**
     * Get trademark
     *
     * @return \ABO\TrademarkBundle\Entity\Trademark
     */
    public function getTrademark()
    {
        return $this->trademark;
    }

    /**
     * Set shop
     *
     * @param \ABO\ShopBundle\Entity\Shop $shop
     *
     * @return CategoryProduct
     */
    public function setShop(\ABO\ShopBundle\Entity\Shop $shop = null)
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

    /**
     * Set rateStat
     *
     * @param \ABO\MainBundle\Entity\RateStat $rateStat
     *
     * @return CategoryProduct
     */
    public function setRateStat(\ABO\MainBundle\Entity\RateStat $rateStat)
    {
        $this->rateStat = $rateStat;

        return $this;
    }

    /**
     * Get rateStat
     *
     * @return \ABO\MainBundle\Entity\RateStat
     */
    public function getRateStat()
    {
        return $this->rateStat;
    }

    /**
     * Set image
     *
     * @param \ABO\MainBundle\Entity\Image $image
     *
     * @return CategoryProduct
     */
    public function setImage(\ABO\MainBundle\Entity\Image $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \ABO\MainBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set arrangement
     *
     * @param \ABO\TrademarkBundle\Entity\Arrangement $arrangement
     *
     * @return CategoryProduct
     */
    public function setArrangement(\ABO\TrademarkBundle\Entity\Arrangement $arrangement = null)
    {
        $this->arrangement = $arrangement;

        return $this;
    }

    /**
     * Get arrangement
     *
     * @return \ABO\TrademarkBundle\Entity\Arrangement
     */
    public function getArrangement() {

        return $this->arrangement;
    }

    /**
     * Set parent
     *
     * @param \ABO\MainBundle\Entity\CategoryProduct $parent
     *
     * @return CategoryProduct
     */
    public function setParent(\ABO\MainBundle\Entity\CategoryProduct $parent = null) {

        $this->setAnyParent(false);
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \ABO\MainBundle\Entity\CategoryProduct
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set anyParent
     *
     * @param boolean $anyParent
     *
     * @return CategoryProduct
     */
    public function setAnyParent($anyParent)
    {
        $this->anyParent = $anyParent;

        return $this;
    }

    /**
     * Get anyParent
     *
     * @return boolean
     */
    public function getAnyParent()
    {
        return $this->anyParent;
    }
}
