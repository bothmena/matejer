<?php

namespace ABO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Size
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ABO\MainBundle\Entity\SizeRepository")
 */
class Size {
    
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
     * @ORM\Column(name="type", type="string", length=3)
     * eur = europe, fr = france, uni = universal
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="age", type="string", length=2)
     * bb = baby, tn = teenage, ad = adult
     */
    private $age;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=2)
     * ml = male, fm = female, mf = both
     */
    private $sexe;

    /**
     * @var string
     *
     * @ORM\Column(name="clothe", type="string", length=2)
     * // sh = shoes, tp = top, bt = bot, pn = panties, sg = soutien gorge, st = standard
     */
    private $clothe;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=5)
     */
    private $value;

    /**
    * @Gedmo\Slug(fields={"type","age","sexe","clothe","value"})
    * @ORM\Column(length=80, unique=true)
    */
    private $slug;
    
    public function __construct($age,$clothe,$sexe,$type) {
        
        $this->age = $age;
        $this->clothe = $clothe;
        $this->sexe = $sexe;
        $this->type = $type;
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
     * Set type
     *
     * @param string $type
     *
     * @return Size
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
     * Set age
     *
     * @param string $age
     *
     * @return Size
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return string
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     *
     * @return Size
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set clothe
     *
     * @param string $clothe
     *
     * @return Size
     */
    public function setClothe($clothe)
    {
        $this->clothe = $clothe;

        return $this;
    }

    /**
     * Get clothe
     *
     * @return string
     */
    public function getClothe()
    {
        return $this->clothe;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return Size
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
     * Set slug
     *
     * @param string $slug
     *
     * @return Size
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
}
