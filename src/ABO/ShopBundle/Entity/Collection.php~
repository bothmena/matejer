<?php

namespace ABO\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Collection
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ABO\ShopBundle\Entity\CollectionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Collection {

    /**
     * @ORM\PrePersist
     */
    public function settingLevel(){
        if($this->getParent())
            $this->setLevel($this->getParent()->getLevel() + 1);
        else
            $this->setLevel(1);
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
    * @ORM\ManyToOne(targetEntity="ABO\MainBundle\Entity\Category")
    */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="ABO\ShopBundle\Entity\Collection")
     */
    private $parent;
    
    /**
    * @ORM\ManyToOne(targetEntity="ABO\ShopBundle\Entity\Shop")
    * @ORM\JoinColumn(nullable=false)
    */
    private $shop;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=61)
     * @Assert\Length(
     *      min = 2,
     *      max = 60,
     *      minMessage = "Collection name must be at least {{ limit }} characters long",
     *      maxMessage = "Collection name cannot be longer than {{ limit }} characters",
     * )
     */
    private $name;
    
    /**
    * @Gedmo\Slug(fields={"name"})
    * @ORM\Column(length=80, unique=true)
    */
    private $slug;

    /**
     * @var integer
     *
     * @ORM\Column(name="productNb", type="integer", options={"unsigned"=true})
     * @Assert\Type("integer")
     */
    private $productNb;

    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="smallint")
     * @Assert\Range(
     *      min = 1,
     *      max = 3,
     *      minMessage = "Minimum level allowed is : {{ limit }}",
     *      maxMessage = "Maximum level allowed is : {{ limit }}"
     * )
     */
    private $level;

    /**
     * @var boolean
     *
     * @ORM\Column(name="anyParent", type="boolean")
     * @Assert\Type(type="bool")
     */
    private $anyParent;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     * @Assert\DateTime()
     */
    private $date;

    public function __construct() {
        
        $this->date = new \DateTime;
        $this->productNb = 0;
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
     * Set name
     *
     * @param string $name
     *
     * @return Collection
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Collection
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Collection
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
     * Set category
     *
     * @param \ABO\MainBundle\Entity\Category $category
     *
     * @return Collection
     */
    public function setCategory(\ABO\MainBundle\Entity\Category $category = null)
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
     * Set shop
     *
     * @param \ABO\ShopBundle\Entity\Shop $shop
     *
     * @return Collection
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
     * Set productNb
     *
     * @param integer $productNb
     *
     * @return Collection
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
     * Set level
     *
     * @param integer $level
     *
     * @return Collection
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set anyParent
     *
     * @param boolean $anyParent
     *
     * @return Collection
     */
    public function setAnyParent($isParent)
    {
        $this->anyParent = $isParent;

        return $this;
    }

    /**
     * Get anyParent
     *
     * @return boolean
     */
    public function getAnyParent()
    {
        return $this->anyParent;
    }

    /**
     * Set parent
     *
     * @param \ABO\ShopBundle\Entity\Collection $parent
     *
     * @return Collection
     */
    public function setParent(\ABO\ShopBundle\Entity\Collection $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \ABO\ShopBundle\Entity\Collection
     */
    public function getParent()
    {
        return $this->parent;
    }
}
