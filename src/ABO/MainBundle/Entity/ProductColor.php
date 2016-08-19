<?php

namespace ABO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductColor
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ABO\MainBundle\Entity\ProductColorRepository")
 */
class ProductColor
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
    * @ORM\ManyToOne(targetEntity="ABO\MainBundle\Entity\Color")
    * @ORM\JoinColumn(nullable=false)
    */
    private $color;
    
    /**
    * @ORM\ManyToOne(targetEntity="ABO\MainBundle\Entity\CategoryProduct")
    * @ORM\JoinColumn(nullable=false)
    */
    private $categoryProduct;



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
     * Set color
     *
     * @param \ABO\MainBundle\Entity\Color $color
     *
     * @return ProductColor
     */
    public function setColor(\ABO\MainBundle\Entity\Color $color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return \ABO\MainBundle\Entity\Color
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set categoryProduct
     *
     * @param \ABO\MainBundle\Entity\CategoryProduct $categoryProduct
     *
     * @return ProductColor
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
