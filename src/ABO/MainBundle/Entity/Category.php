<?php

namespace ABO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Category
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ABO\MainBundle\Entity\CategoryRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Category
{
    
    /**
    * @ORM\PrePersist
    */
    public function level(){
        $parent = $this->getParent();
        if($parent){
            $level = $parent->getLevel() + 1;
            $this->setLevel($level);
            $this->setParentName($parent->getSlug());
        }
        else{
            $this->setLevel(1);
            $this->setParentName('null');
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
    private $parent;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="specsClass", type="string", length=61)
     * @Assert\Length(
     *      min = 2,
     *      max = 60,
     *      minMessage = "Category name must be at least {{ limit }} characters long",
     *      maxMessage = "Category name cannot be longer than {{ limit }} characters",
     * )
     */
    private $specsClass;

    /**
    * @Gedmo\Slug(fields={"name"})
    * @ORM\Column(length=80, unique=true)
    */
    private $slug;

    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="smallint")
     * @Assert\Range(
     *      min = 0,
     *      max = 4,
     *      minMessage = "Minimum level is {{ limit }}",
     *      maxMessage = "Maximum level is {{ limit }}"
     * )
     */
    private $level;

    /**
     * @var string
     *
     * @ORM\Column(name="parentName", type="string", length=80)
     */
    private $parentName;

    public function __construct() {
        
        $this->specsClass = '';
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
     * Get transParent
     *
     * @return integer
     */
    public function getTransParent() {
        
        return 'matejer_category.'.$this->parentName;
    }
    
    /**
     * Get translatable
     *
     * @return integer
     */
    public function getTranslatable()
    {
        return 'matejer_category.'.$this->slug;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Category
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
     * @return Category
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
     * Set level
     *
     * @param integer $level
     *
     * @return Category
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
     * Set parentName
     *
     * @param string $parentName
     *
     * @return Category
     */
    public function setParentName($parentName)
    {
        $this->parentName = $parentName;

        return $this;
    }

    /**
     * Get parentName
     *
     * @return string
     */
    public function getParentName()
    {
        return $this->parentName;
    }

    /**
     * Set parent
     *
     * @param \ABO\MainBundle\Entity\Category $parent
     *
     * @return Category
     */
    public function setParent(\ABO\MainBundle\Entity\Category $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \ABO\MainBundle\Entity\Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set specsClass
     *
     * @param string $specsClass
     *
     * @return Category
     */
    public function setSpecsClass($specsClass)
    {
        $this->specsClass = $specsClass;

        return $this;
    }

    /**
     * Get specsClass
     *
     * @return string
     */
    public function getSpecsClass()
    {
        return $this->specsClass;
    }
}
