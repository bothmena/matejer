<?php

namespace ABO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * GenSpec
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ABO\MainBundle\Entity\GeneralSpecRepository")
 */
class GeneralSpec {

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
     * @ORM\Column(name="specsClass", type="string", length=255)
     */
    private $specsClass;

    /**
     * @var string
     *
     * @ORM\Column(name="source", type="string", length=255, nullable=true)
     * @Assert\Url()
     */
    private $source;

    /**
     * @var string
     *
     * @ORM\Column(name="video", type="string", length=255, nullable=true)
     */
    private $video;

    /**
     * @var string
     *
     * @ORM\Column(name="videoSite", type="string", length=15, nullable=true)
     */
    private $videoSite;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="colors", type="string", length=255, nullable=true)
     */
    private $colors;

    /**
     * @var string
     *
     * @ORM\Column(name="one", type="string", length=255, nullable=true)
     */
    private $one;

    /**
     * @var string
     *
     * @ORM\Column(name="two", type="string", length=255, nullable=true)
     */
    private $two;

    /**
     * @var string
     *
     * @ORM\Column(name="three", type="string", length=255, nullable=true)
     */
    private $three;

    /**
     * @var string
     *
     * @ORM\Column(name="four", type="string", length=255, nullable=true)
     */
    private $four;

    /**
     * @var string
     *
     * @ORM\Column(name="five", type="string", length=255, nullable=true)
     */
    private $five;

    /**
     * @var string
     *
     * @ORM\Column(name="six", type="string", length=255, nullable=true)
     */
    private $six;

    /**
     * @var string
     *
     * @ORM\Column(name="seven", type="string", length=255, nullable=true)
     */
    private $seven;

    /**
     * @var string
     *
     * @ORM\Column(name="eight", type="string", length=255, nullable=true)
     */
    private $eight;

    /**
     * @var string
     *
     * @ORM\Column(name="nine", type="string", length=255, nullable=true)
     */
    private $nine;

    /**
     * @var string
     *
     * @ORM\Column(name="ten", type="string", length=255, nullable=true)
     */
    private $ten;

    /**
     * @param GeneralSpec $gs
     * @return GeneralSpec
     */
    public function setData(GeneralSpec $gs){

        $this->description = $gs->getDescription();
        $this->one = $gs->getOne();
        $this->two = $gs->getTwo();
        $this->three = $gs->getThree();
        $this->four = $gs->getFour();
        $this->five = $gs->getFive();
        $this->six = $gs->getSix();
        $this->seven = $gs->getSeven();
        $this->eight = $gs->getEight();
        $this->nine = $gs->getNine();
        $this->ten = $gs->getTen();
        $this->source = $gs->getSource();
        $this->video = $gs->getVideo();
        $this->videoSite = $gs->getVideoSite();

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
     * Set specsClass
     *
     * @param string $specsClass
     *
     * @return GeneralSpec
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

    /**
     * Set source
     *
     * @param string $source
     *
     * @return GeneralSpec
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set video
     *
     * @param string $video
     *
     * @return GeneralSpec
     */
    public function setVideo($video) {

        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return string
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return GeneralSpec
     */
    public function setDescription($description)
    {
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

    /**
     * Set one
     *
     * @param string $one
     *
     * @return GeneralSpec
     */
    public function setOne($one)
    {
        $this->one = $one;

        return $this;
    }

    /**
     * Get one
     *
     * @return string
     */
    public function getOne()
    {
        return $this->one;
    }

    /**
     * Set two
     *
     * @param string $two
     *
     * @return GeneralSpec
     */
    public function setTwo($two)
    {
        $this->two = $two;

        return $this;
    }

    /**
     * Get two
     *
     * @return string
     */
    public function getTwo()
    {
        return $this->two;
    }

    /**
     * Set three
     *
     * @param string $three
     *
     * @return GeneralSpec
     */
    public function setThree($three)
    {
        $this->three = $three;

        return $this;
    }

    /**
     * Get three
     *
     * @return string
     */
    public function getThree()
    {
        return $this->three;
    }

    /**
     * Set four
     *
     * @param string $four
     *
     * @return GeneralSpec
     */
    public function setFour($four)
    {
        $this->four = $four;

        return $this;
    }

    /**
     * Get four
     *
     * @return string
     */
    public function getFour()
    {
        return $this->four;
    }

    /**
     * Set five
     *
     * @param string $five
     *
     * @return GeneralSpec
     */
    public function setFive($five)
    {
        $this->five = $five;

        return $this;
    }

    /**
     * Get five
     *
     * @return string
     */
    public function getFive()
    {
        return $this->five;
    }

    /**
     * Set six
     *
     * @param string $six
     *
     * @return GeneralSpec
     */
    public function setSix($six)
    {
        $this->six = $six;

        return $this;
    }

    /**
     * Get six
     *
     * @return string
     */
    public function getSix()
    {
        return $this->six;
    }

    /**
     * Set seven
     *
     * @param string $seven
     *
     * @return GeneralSpec
     */
    public function setSeven($seven)
    {
        $this->seven = $seven;

        return $this;
    }

    /**
     * Get seven
     *
     * @return string
     */
    public function getSeven()
    {
        return $this->seven;
    }

    /**
     * Set eight
     *
     * @param string $eight
     *
     * @return GeneralSpec
     */
    public function setEight($eight)
    {
        $this->eight = $eight;

        return $this;
    }

    /**
     * Get eight
     *
     * @return string
     */
    public function getEight()
    {
        return $this->eight;
    }

    /**
     * Set nine
     *
     * @param string $nine
     *
     * @return GeneralSpec
     */
    public function setNine($nine)
    {
        $this->nine = $nine;

        return $this;
    }

    /**
     * Get nine
     *
     * @return string
     */
    public function getNine()
    {
        return $this->nine;
    }

    /**
     * Set ten
     *
     * @param string $ten
     *
     * @return GeneralSpec
     */
    public function setTen($ten)
    {
        $this->ten = $ten;

        return $this;
    }

    /**
     * Get ten
     *
     * @return string
     */
    public function getTen()
    {
        return $this->ten;
    }

    /**
     * Set videoSite
     *
     * @param string $videoSite
     *
     * @return GeneralSpec
     */
    public function setVideoSite($videoSite)
    {
        $this->videoSite = $videoSite;

        return $this;
    }

    /**
     * Get videoSite
     *
     * @return string
     */
    public function getVideoSite()
    {
        return $this->videoSite;
    }

    /**
     * Set colors
     *
     * @param string $colors
     *
     * @return GeneralSpec
     */
    public function setColors($colors)
    {
        $this->colors = $colors;

        return $this;
    }

    /**
     * Get colors
     *
     * @return string
     */
    public function getColors()
    {
        return $this->colors;
    }
}
