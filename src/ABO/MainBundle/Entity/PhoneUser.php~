<?php

namespace ABO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PhoneUser
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ABO\MainBundle\Entity\PhoneUserRepository")
 */
class PhoneUser {
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="ABO\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

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
     * @return PhoneUser
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
     * @return PhoneUser
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
     * Set user
     *
     * @param \ABO\UserBundle\Entity\User $user
     *
     * @return PhoneUser
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
