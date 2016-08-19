<?php

namespace ABO\MainBundle\Entity;

use ABO\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * ImageUser
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ABO\MainBundle\Entity\ImageUserRepository")
 */
class ImageUser
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
     * @ORM\ManyToOne(targetEntity="ABO\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
    
    /**
     * @ORM\ManyToOne(targetEntity="ABO\MainBundle\Entity\Image",cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $image;

    public function __construct( Image $image = null, User $user = null ) {

        $this->image = $image;
        $this->user = $user;
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
     * Set user
     *
     * @param \ABO\UserBundle\Entity\User $user
     *
     * @return ImageUser
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

    /**
     * Set image
     *
     * @param \ABO\MainBundle\Entity\Image $image
     *
     * @return ImageUser
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
