<?php

namespace ABO\MainBundle\Entity;

use ABO\TrademarkBundle\Entity\Trademark;
use Doctrine\ORM\Mapping as ORM;

/**
 * ImageTrademark
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ImageTrademark
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
     * @ORM\ManyToOne(targetEntity="ABO\MainBundle\Entity\Image",cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $image;

    public function __construct(Trademark $trademark, Image $image) {

        $this->trademark = $trademark;
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
     * Set trademark
     *
     * @param \ABO\TrademarkBundle\Entity\Trademark $trademark
     *
     * @return ImageTrademark
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
     * Set image
     *
     * @param \ABO\MainBundle\Entity\Image $image
     *
     * @return ImageTrademark
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
