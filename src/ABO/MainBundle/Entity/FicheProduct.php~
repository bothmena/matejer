<?php

namespace ABO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * FicheProduct
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class FicheProduct {

    /**
     * @ORM\PrePersist
     */
    public function prePersist(){
        if(empty($this->getName())){
            $this->setType('simple');
            $this->name = '';
        }
        else
            $this->setType('double');
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=61)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="f_group", type="string", length=61)
     */
    private $group;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="text")
     */
    private $value;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=6)
     * @Assert\Choice(choices = {"single", "double"}, message = "Choose a valid type.")
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=2)
     * @Assert\Choice(choices = {"en", "fr", "ar"}, message = "Choose a valid language.")
     */
    private $language;
    
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
     * @return FicheProduct
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
     * Set type
     *
     * @param string $type
     *
     * @return FicheProduct
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set categoryProduct
     *
     * @param \ABO\MainBundle\Entity\CategoryProduct $categoryProduct
     *
     * @return FicheProduct
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
     * Set group
     *
     * @param string $group
     *
     * @return FicheProduct
     */
    public function setGroup($group)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return string
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return FicheProduct
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set language
     *
     * @param string $language
     *
     * @return FicheProduct
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }
}
