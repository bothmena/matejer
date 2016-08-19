<?php

namespace ABO\MainBundle\Entity;

use ABO\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Wishlist
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ABO\MainBundle\Entity\WishlistRepository")
 */
class Wishlist
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

    public function __construct(CategoryProduct $categoryProduct, UserInterface $user) {

        $this->categoryProduct = $categoryProduct;
        $this->user = $user;
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
     * @return Wishlist
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
     * Set categoryProduct
     *
     * @param \ABO\MainBundle\Entity\CategoryProduct $categoryProduct
     *
     * @return Wishlist
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
     * Set user
     *
     * @param \ABO\UserBundle\Entity\User $user
     *
     * @return Wishlist
     */
    public function setUser(User $user)
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
