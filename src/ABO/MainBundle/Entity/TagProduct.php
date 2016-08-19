<?php

namespace ABO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TagProduct
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class TagProduct {
    
    /**
     * @ORM\PrePersist
     */
    public function slugTag(){
    
        $this->slugTag = $this->tag->getSlug();
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
     * @ORM\ManyToOne(targetEntity="ABO\MainBundle\Entity\CategoryProduct")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categoryProduct;

    /**
    * @ORM\ManyToOne(targetEntity="ABO\MainBundle\Entity\Tag")
    * @ORM\JoinColumn(nullable=false)
    */
    private $tag;

    /**
     * @var string
     *
     * @ORM\Column(name="slugTag", type="string", length=80)
     */
    private $slugTag;

    /**
     * @var string
     *
     * @ORM\Column(name="stat", type="string", length=2)
     * // Size: A(vailable)|U(uavailable)
     * // Place: C(country) | S(state) | I(city)
     * // Category 1 | 2 | 3 => level
     * // hasDiscount 10(10%) | 20(20%) ...
     * // rate => 0-star ---> 5-star (arrondi)
     * 
     */
    private $stat;
    
    public function __construct() {
        
        $this->stat = '';
    }
    
    /**
     * Get translatable
     *
     * @return integer
     */
    public function getTranslatable() {
        
        switch ($this->getTag()->getType()) {
            case 'size':
                return 'matejer_size.'.$this->getTag()->getName();
            case 'color':
                return 'matejer_color.'.$this->getTag()->getName();
            case 'place':
                return 'matejer_place.'.$this->getTag()->getName();
            case 'category':
                return 'matejer_category.'.$this->getTag()->getName();
            case 'hasDiscount':
                return $this->stat;
            case 'feature':
                return $this->getTag()->getName();
            case 'arrangement':
                return $this->getTag()->getName();
            case 'personal':
                return $this->getTag()->getName();
            default:
                return $this->getTag()->getName();
        }
        return 'matejer_category.'.$this->slug;
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
     * Set slugTag
     *
     * @param string $slugTag
     *
     * @return TagProduct
     */
    public function setSlugTag($slugTag)
    {
        $this->slugTag = $slugTag;

        return $this;
    }

    /**
     * Get slugTag
     *
     * @return string
     */
    public function getSlugTag()
    {
        return $this->slugTag;
    }

    /**
     * Set categoryProduct
     *
     * @param \ABO\MainBundle\Entity\CategoryProduct $categoryProduct
     *
     * @return TagProduct
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
     * Set tag
     *
     * @param \ABO\MainBundle\Entity\Tag $tag
     *
     * @return TagProduct
     */
    public function setTag(\ABO\MainBundle\Entity\Tag $tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return \ABO\MainBundle\Entity\Tag
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set stat
     *
     * @param string $stat
     *
     * @return TagProduct
     */
    public function setStat($stat)
    {
        $this->stat = $stat;

        return $this;
    }

    /**
     * Get stat
     *
     * @return string
     */
    public function getStat()
    {
        return $this->stat;
    }
}
