<?php

namespace ABO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TagShop
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */

class TagShop {
    
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
     * @ORM\ManyToOne(targetEntity="ABO\ShopBundle\Entity\Shop")
     * @ORM\JoinColumn(nullable=false)
     */
    private $shop;

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
     * Get id
     *
     * @return integer
     */
    public function getId() {
        
        return $this->id;
    }

    /**
     * Set slugTag
     *
     * @param string $slugTag
     *
     * @return TagShop
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
     * Set shop
     *
     * @param \ABO\ShopBundle\Entity\Shop $shop
     *
     * @return TagShop
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
     * Set tag
     *
     * @param \ABO\MainBundle\Entity\Tag $tag
     *
     * @return TagShop
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
}
