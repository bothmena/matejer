<?php

namespace ABO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ImageProduct
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ABO\MainBundle\Entity\ImageProductRepository")
 */
class ImageProduct
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
     * @ORM\ManyToOne(targetEntity="ABO\MainBundle\Entity\Image",cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $image;

    public function __construct(CategoryProduct $categoryProduct, Image $image) {

        $this->categoryProduct = $categoryProduct;
        $this->image = $image;
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
     * Set categoryProduct
     *
     * @param \ABO\MainBundle\Entity\CategoryProduct $categoryProduct
     *
     * @return ImageProduct
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
     * Set image
     *
     * @param \ABO\MainBundle\Entity\Image $image
     *
     * @return ImageProduct
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
}
