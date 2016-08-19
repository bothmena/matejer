<?php

namespace ABO\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShopUser
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ABO\ShopBundle\Entity\ShopUserRepository")
 */
class ShopUser
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
     * @ORM\ManyToOne(targetEntity="ABO\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
   private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    public function __construct() {
        
        $this->date = new \DateTime;
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return ShopUser
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
     * Set shop
     *
     * @param \ABO\ShopBundle\Entity\Shop $shop
     *
     * @return ShopUser
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
     * Set user
     *
     * @param \ABO\UserBundle\Entity\User $user
     *
     * @return ShopUser
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
}
