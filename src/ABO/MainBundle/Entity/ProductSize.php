<?php

namespace ABO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductSize
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ProductSize
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
     * @ORM\ManyToOne(targetEntity="ABO\MainBundle\Entity\CategoryProduct", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $categoryProduct;
    
    /**
     * @ORM\ManyToOne(targetEntity="ABO\MainBundle\Entity\Size")
     * @ORM\JoinColumn(nullable=false)
     */
    private $size;

    /**
     * @var boolean
     *
     * @ORM\Column(name="available", type="boolean")
     */
    private $available;


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
     * Set available
     *
     * @param boolean $available
     *
     * @return ProductSize
     */
    public function setAvailable($available)
    {
        $this->available = $available;

        return $this;
    }

    /**
     * Get available
     *
     * @return boolean
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * Set categoryProduct
     *
     * @param \ABO\MainBundle\Entity\CategoryProduct $categoryProduct
     *
     * @return ProductSize
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

    /**
     * Set size
     *
     * @param \ABO\MainBundle\Entity\Size $size
     *
     * @return ProductSize
     */
    public function setSize(\ABO\MainBundle\Entity\Size $size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return \ABO\MainBundle\Entity\Size
     */
    public function getSize()
    {
        return $this->size;
    }
}
