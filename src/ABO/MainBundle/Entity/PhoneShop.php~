<?php

namespace ABO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * PhoneShop
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ABO\MainBundle\Entity\PhoneShopRepository")
 * @UniqueEntity(fields="subscriber", message="This phone number is taken.")
 */
class PhoneShop
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
     * @var string
     *
     * @ORM\Column(name="phoneCode", type="string", length=6)
     */
    private $phoneCode;

    /**
     * @var string
     *
     * @ORM\Column(name="subscriber", type="string", length=30, unique=true)
     */
    private $subscriber;

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
     * Get full
     *
     * @return string
     */
    public function getFull()
    {
        return '(' . $this->phoneCode . ') ' . $this->subscriber;
    }

    /**
     * Set phoneCode
     *
     * @param string $phoneCode
     *
     * @return PhoneShop
     */
    public function setPhoneCode($phoneCode)
    {
        $this->phoneCode = $phoneCode;

        return $this;
    }

    /**
     * Get phoneCode
     *
     * @return string
     */
    public function getPhoneCode()
    {
        return $this->phoneCode;
    }

    /**
     * Set subscriber
     *
     * @param string $subscriber
     *
     * @return PhoneShop
     */
    public function setSubscriber($subscriber)
    {
        $this->subscriber = $subscriber;

        return $this;
    }

    /**
     * Get subscriber
     *
     * @return string
     */
    public function getSubscriber()
    {
        return $this->subscriber;
    }

    /**
     * Set shop
     *
     * @param \ABO\ShopBundle\Entity\Shop $shop
     *
     * @return PhoneShop
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
}
