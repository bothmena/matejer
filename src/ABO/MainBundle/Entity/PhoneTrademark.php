<?php

namespace ABO\MainBundle\Entity;

use ABO\TrademarkBundle\Entity\Trademark;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * PhoneTrademark
 *
 * @ORM\Table()
 * @ORM\Entity
 * @UniqueEntity(fields="subscriber", message="This phone number is taken.")
 */
class PhoneTrademark
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
     * Set phoneCode
     *
     * @param string $phoneCode
     *
     * @return PhoneTrademark
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
     * @return PhoneTrademark
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
     * Set trademark
     *
     * @param \ABO\TrademarkBundle\Entity\Trademark $trademark
     *
     * @return PhoneTrademark
     */
    public function setTrademark(Trademark $trademark)
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
}
