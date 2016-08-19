<?php

namespace ABO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FeatureProduct
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class FeatureProduct
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
    * @ORM\ManyToOne(targetEntity="ABO\MainBundle\Entity\CategoryProduct")
    * @ORM\JoinColumn(nullable=false)
    */
    private $categoryProduct;
    
    /**
    * @ORM\ManyToOne(targetEntity="ABO\MainBundle\Entity\Feature")
    * @ORM\JoinColumn(nullable=false)
    */
    private $feature;

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
     * Set categoryProduct
     *
     * @param \ABO\MainBundle\Entity\CategoryProduct $categoryProduct
     *
     * @return FeatureProduct
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
     * Set feature
     *
     * @param \ABO\MainBundle\Entity\Feature $feature
     *
     * @return FeatureProduct
     */
    public function setFeature(\ABO\MainBundle\Entity\Feature $feature)
    {
        $this->feature = $feature;

        return $this;
    }

    /**
     * Get feature
     *
     * @return \ABO\MainBundle\Entity\Feature
     */
    public function getFeature()
    {
        return $this->feature;
    }
}
