<?php

namespace ABO\ShopBundle\Entity;

use ABO\MainBundle\Entity\Category;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CategoryShop
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ABO\ShopBundle\Entity\CategoryShopRepository")
 */
class CategoryShop {
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="ABO\MainBundle\Entity\Category")
     * @ORM\JoinColumn(nullable=false)
     */
   private $category;
   
    /**
     * @ORM\ManyToOne(targetEntity="ABO\ShopBundle\Entity\Shop")
     * @ORM\JoinColumn(nullable=false)
     */
   private $shop;

    /**
     * @var integer
     *
     * @ORM\Column(name="productNb", type="integer", options={"unsigned"=true})
     * @Assert\Type("integer")
     */
    private $productNb;

    public function __construct( Category $category = null, Shop $shop = null ) {

        $this->category = $category;
        $this->shop = $shop;
        $this->productNb = 0;
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
     * Set category
     *
     * @param \ABO\MainBundle\Entity\Category $category
     *
     * @return CategoryShop
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
     * Set shop
     *
     * @param \ABO\ShopBundle\Entity\Shop $shop
     *
     * @return CategoryShop
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

    /**
     * Set productNb
     *
     * @param integer $productNb
     *
     * @return CategoryShop
     */
    public function setProductNb($productNb)
    {
        $this->productNb = $productNb;

        return $this;
    }

    /**
     * Get productNb
     *
     * @return integer
     */
    public function getProductNb()
    {
        return $this->productNb;
    }
}
