<?php

namespace ABO\TrademarkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Arrangement
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Arrangement
{
    
    /**
    * @ORM\PrePersist
    */
    public function level(){
        if($this->getParent()){
            $level = $this->getParent()->getLevel() + 1;
            $this->setLevel($level);
        }
        else{
            $this->setLevel(1);
        }
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
     * @ORM\ManyToOne(targetEntity="ABO\TrademarkBundle\Entity\Trademark")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trademark;
    
    /**
     * @ORM\ManyToOne(targetEntity="ABO\TrademarkBundle\Entity\Arrangement")
     */
    private $parent;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=61)
     * @Assert\Length(
     *      min = 2,
     *      max = 60,
     *      minMessage = "Your shop name must be at least {{ limit }} characters long",
     *      maxMessage = "Your shop name cannot be longer than {{ limit }} characters",
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\Length(
     *      min = 0,
     *      max = 1000,
     *      minMessage = "Your shop description must be at least {{ limit }} characters long",
     *      maxMessage = "Your shop description cannot be longer than {{ limit }} characters",
     * )
     */
    private $description;
    
    /**
    * @Gedmo\Slug(fields={"name"})
    * @ORM\Column(length=100, unique=true)
    */
    private $slug;

    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="smallint")
     * @Assert\Range(
     *      min = 1,
     *      max = 5,
     *      minMessage = "Minimum level allowed is : {{ limit }}",
     *      maxMessage = "Maximum level allowed is : {{ limit }}"
     * )
     */
    private $level;

    /**
     * @var boolean
     *
     * @ORM\Column(name="toProduct", type="boolean")
     * @Assert\Type(type="bool")
     */
    private $toProduct;
    
    public function __construct() {
        
        $this->toProduct = true;
        $this->description = '';
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
     * @return Arrangement
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
     * Set level
     *
     * @param integer $level
     *
     * @return Arrangement
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
     * Set slug
     *
     * @param string $slug
     *
     * @return Arrangement
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
     * Set category
     *
     * @param \ABO\MainBundle\Entity\Category $category
     *
     * @return Arrangement
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
     * Set trademark
     *
     * @param \ABO\TrademarkBundle\Entity\Trademark $trademark
     *
     * @return Arrangement
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
     * Set parent
     *
     * @param \ABO\TrademarkBundle\Entity\Arrangement $parent
     *
     * @return Arrangement
     */
    public function setParent(\ABO\TrademarkBundle\Entity\Arrangement $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \ABO\TrademarkBundle\Entity\Arrangement
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set toProduct
     *
     * @param boolean $toProduct
     *
     * @return Arrangement
     */
    public function setToProduct($toProduct)
    {
        $this->toProduct = $toProduct;

        return $this;
    }

    /**
     * Get toProduct
     *
     * @return boolean
     */
    public function getToProduct()
    {
        return $this->toProduct;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Arrangement
     */
    public function setDescription($description) {

        if(empty($this->description))
            $this->description = '';
        else
            $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
