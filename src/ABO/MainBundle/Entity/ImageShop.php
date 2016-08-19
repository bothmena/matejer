<?php

namespace ABO\MainBundle\Entity;

use ABO\ShopBundle\Entity\Shop;
use Doctrine\ORM\Mapping as ORM;

/**
 * ImageShop
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ABO\MainBundle\Entity\ImageShopRepository")
 */
class ImageShop
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
     * @ORM\ManyToOne(targetEntity="ABO\ShopBundle\Entity\Shop")
     * @ORM\JoinColumn(nullable=false)
     */
    private $shop;
    
    /**
     * @ORM\ManyToOne(targetEntity="ABO\MainBundle\Entity\Image",cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $image;

    public function __construct(Shop $shop = null, Image $image = null) {

        $this->shop = $shop;
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
     * Set shop
     *
     * @param \ABO\ShopBundle\Entity\Shop $shop
     *
     * @return ImageShop
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
     * Set image
     *
     * @param \ABO\MainBundle\Entity\Image $image
     *
     * @return ImageShop
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
