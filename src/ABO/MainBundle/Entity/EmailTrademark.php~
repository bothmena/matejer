<?php

namespace ABO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * EmailShop
 *
 * @ORM\Table()
 * @ORM\Entity
 * @UniqueEntity(fields={"email","code"})
 */
class EmailTrademark {
    
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
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     */
    private $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="confirmed", type="boolean")
     */
    private $confirmed;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=32, unique=true)
     */
    private $code;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deadline", type="datetime")
     */
    private $deadline;

    public function __construct() {

        $this->confirmed = false;
    }

    public function confirm() {
        
        $this->confirmed = true;
        $this->code = '';
        
        return $this;
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
     * Set email
     *
     * @param string $email
     *
     * @return EmailTrademark
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set confirmed
     *
     * @param boolean $confirmed
     *
     * @return EmailTrademark
     */
    public function setConfirmed($confirmed)
    {
        $this->confirmed = $confirmed;

        return $this;
    }

    /**
     * Get confirmed
     *
     * @return boolean
     */
    public function getConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return EmailTrademark
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set deadline
     *
     * @param \DateTime $deadline
     *
     * @return EmailTrademark
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;

        return $this;
    }

    /**
     * Get deadline
     *
     * @return \DateTime
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * Set trademark
     *
     * @param \ABO\TrademarkBundle\Entity\Trademark $trademark
     *
     * @return EmailTrademark
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
}
