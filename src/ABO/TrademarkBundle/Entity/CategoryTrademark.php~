<?php

namespace ABO\TrademarkBundle\Entity;

use ABO\MainBundle\Entity\Category;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CategoryTrademark
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ABO\TrademarkBundle\Entity\CategoryTrademarkRepository")
 */
class CategoryTrademark
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
    * @ORM\ManyToOne(targetEntity="ABO\TrademarkBundle\Entity\Trademark")
     * @ORM\JoinColumn(nullable=false)
    */
    private $trademark;
    
    /**
    * @ORM\ManyToOne(targetEntity="ABO\MainBundle\Entity\Category")
     * @ORM\JoinColumn(nullable=false)
    */
    private $category;

    /**
     * @var integer
     *
     * @ORM\Column(name="productNb", type="integer", options={"unsigned"=true})
     * @Assert\Type("integer")
     */
    private $productNb;
    
    public function __construct( Category $category, Trademark $trademark ){

        $this->category = $category;
        $this->trademark = $trademark;
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
     * Set productNb
     *
     * @param integer $productNb
     *
     * @return CategoryTrademark
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

    /**
     * Set trademark
     *
     * @param \ABO\TrademarkBundle\Entity\Trademark $trademark
     *
     * @return CategoryTrademark
     */
    public function setTrademark(\ABO\TrademarkBundle\Entity\Trademark $trademark)
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
     * Set category
     *
     * @param \ABO\MainBundle\Entity\Category $category
     *
     * @return CategoryTrademark
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
}
