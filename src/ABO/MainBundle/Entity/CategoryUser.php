<?php

namespace ABO\MainBundle\Entity;

use ABO\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CategoryUser
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ABO\MainBundle\Entity\CategoryUserRepository")
 */
class CategoryUser
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
     * @ORM\ManyToOne(targetEntity="ABO\MainBundle\Entity\Category")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @var integer
     *
     * @ORM\Column(name="productNb", type="integer", options={"unsigned"=true})
     * @Assert\Type("integer")
     */
    private $productNb;

    /**
     * @var boolean
     *
     * @ORM\Column(name="chosen", type="boolean")
     */
    private $chosen;

    public function __construct( Category $category = null, User $user = null ) {
        
        $this->productNb = 0;
        $this->chosen = true;
        $this->category = $category;
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
     * Set productNb
     *
     * @param integer $productNb
     *
     * @return CategoryUser
     */
    public function setProductNb($productNb)
    {
        $this->productNb = $productNb;

        return $this;
    }

    /**
     * Get productNb
     *
     * @return integer
     */
    public function getProductNb()
    {
        return $this->productNb;
    }

    /**
     * Set user
     *
     * @param \ABO\UserBundle\Entity\User $user
     *
     * @return CategoryUser
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
     * Set category
     *
     * @param \ABO\MainBundle\Entity\Category $category
     *
     * @return CategoryUser
     */
    public function setCategory(\ABO\MainBundle\Entity\Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \ABO\MainBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set chosen
     *
     * @param boolean $chosen
     *
     * @return CategoryUser
     */
    public function setChosen($chosen)
    {
        $this->chosen = $chosen;

        return $this;
    }

    /**
     * Get chosen
     *
     * @return boolean
     */
    public function getChosen()
    {
        return $this->chosen;
    }
}
