<?php

namespace ABO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Product
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ABO\MainBundle\Entity\ProductRepository")
 * @UniqueEntity(fields="reference", message="Un produit existe déjà avec ce reference.")
 */
class Product {
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=100)
     * @Assert\Expression(
     *     expression=" this.checkReference() ",
     *     message="Either reference or name must be set"
     * )
     * @Assert\Length(
     *      min = 4,
     *      max = 100,
     *      minMessage = "Your last name must be at least {{ limit }} characters long",
     *      maxMessage = "Your last name cannot be longer than {{ limit }} characters"
     * )
     */
    private $reference;

    /**
    * @Gedmo\Slug(fields={"reference"})
    * @ORM\Column(length=128, unique=true)
    */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=120)
     * @Assert\Length(
     *      min = 0,
     *      max = 120,
     *      minMessage = "Your last name must be at least {{ limit }} characters long",
     *      maxMessage = "Your last name cannot be longer than {{ limit }} characters",
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="mark", type="string", length=61)
     * @Assert\Length(
     *      min = 0,
     *      max = 60,
     *      minMessage = "Your last name must be at least {{ limit }} characters long",
     *      maxMessage = "Your last name cannot be longer than {{ limit }} characters",
     * )
     */
    private $mark;

    /**
     * @var boolean
     *
     * @ORM\Column(name="public", type="boolean")
     * @Assert\Type("bool")
     */
    private $public;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     * @Assert\DateTime()
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="folder", type="string", length=255, unique=true)
     */
    private $folder;

    /**
     * @var integer
     *
     * @ORM\Column(name="favoredNb", type="integer", options={"unsigned"=true})
     * @Assert\Type("integer")
     */
    private $favoredNb;
    

    public function __construct() {
        
        $this->date = new \DateTime;
        $this->favoredNb = 0;
        $this->mark = '';
        $this->public = true;
    }
    
    /**
     * Get nameOrReference
     *
     * @return integer
     */
    public function getNameOrReference(){
        
        if($this->isUseful($this->name))
            return $this->name;
        else if ($this->isUseful($this->reference))
            return $this->reference;
    }
    
    private function isUseful($var){
        
        if( empty($var) )
            return false;
        else
            return true;
    }
    
    public function checkReference(){
        
        if( !$this->isUseful($this->reference) && !$this->isUseful($this->name))
            return false;
        else if( !$this->isUseful($this->reference) && $this->isUseful($this->name) ){
            $this->reference = $this->name;
            return true;
        }
        else if($this->name === null) {
            $this->name = '';
            return true;
        }else
            return true;
    }
    
    public function fullname() {
        
        $name = '';
        if( $this->trademark )
            $name = $name.$this->trademark->getName();
        else
            $name = $name.$this->mark;
        
        return $name.' - '.$this->getNameOrReference();
    }

    /**
     * @param Product $product
     * @return Product
     */
    public function setData(Product $product){

        $this->reference = $product->getReference();
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
     * Set reference
     *
     * @param string $reference
     *
     * @return Product
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Product
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
     * Set name
     *
     * @param string $name
     *
     * @return Product
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
     * Set mark
     *
     * @param string $mark
     *
     * @return Product
     */
    public function setMark($mark)
    {
        $this->mark = $mark;

        return $this;
    }

    /**
     * Get mark
     *
     * @return string
     */
    public function getMark()
    {
        return $this->mark;
    }

    /**
     * Set public
     *
     * @param boolean $public
     *
     * @return Product
     */
    public function setPublic($public)
    {
        $this->public = $public;

        return $this;
    }

    /**
     * Get public
     *
     * @return boolean
     */
    public function getPublic()
    {
        return $this->public;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Product
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
     * Set folder
     *
     * @param string $folder
     *
     * @return Product
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;

        return $this;
    }

    /**
     * Get folder
     *
     * @return string
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * Set favoredNb
     *
     * @param integer $favoredNb
     *
     * @return Product
     */
    public function setFavoredNb($favoredNb)
    {
        $this->favoredNb = $favoredNb;

        return $this;
    }

    /**
     * Get favoredNb
     *
     * @return integer
     */
    public function getFavoredNb()
    {
        return $this->favoredNb;
    }
}
