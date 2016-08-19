<?php

namespace ABO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Rate
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Rate {

    /**
     * @ORM\PrePersist
     */
    public function nullToZero(){

        if(empty($this->valueOne))
            $this->valueOne = 0;
        if(empty($this->valueTwo))
            $this->valueTwo = 0;
        if(empty($this->valueThree))
            $this->valueThree = 0;
        if(empty($this->valueFour))
            $this->valueFour = 0;
        if(empty($this->comment))
            $this->comment = '';
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
     * @var integer
     *
     * @ORM\Column(name="value", type="smallint")
     * @Assert\Range(
     *      min = 1,
     *      max = 5,
     *      minMessage = "Minimum rating value is {{ limit }}",
     *      maxMessage = "Maximum rating value is {{ limit }}"
     * )
     */
    private $value;

    /**
     * @var integer
     *
     * @ORM\Column(name="valueOne", type="smallint")
     * @Assert\Range(
     *      min = 1,
     *      max = 5,
     *      minMessage = "Minimum rating value is {{ limit }}",
     *      maxMessage = "Maximum rating value is {{ limit }}"
     * )
     */
    private $valueOne;

    /**
     * @var integer
     *
     * @ORM\Column(name="valueTwo", type="smallint")
     * @Assert\Range(
     *      min = 1,
     *      max = 5,
     *      minMessage = "Minimum rating value is {{ limit }}",
     *      maxMessage = "Maximum rating value is {{ limit }}"
     * )
     */
    private $valueTwo;

    /**
     * @var integer
     *
     * @ORM\Column(name="valueThree", type="smallint")
     * @Assert\Range(
     *      min = 1,
     *      max = 5,
     *      minMessage = "Minimum rating value is {{ limit }}",
     *      maxMessage = "Maximum rating value is {{ limit }}"
     * )
     */
    private $valueThree;

    /**
     * @var integer
     *
     * @ORM\Column(name="valueFour", type="smallint")
     * @Assert\Range(
     *      min = 1,
     *      max = 5,
     *      minMessage = "Minimum rating value is {{ limit }}",
     *      maxMessage = "Maximum rating value is {{ limit }}"
     * )
     */
    private $valueFour;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text")
     */
    private $comment;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        
        return $this->id;
    }

    /**
     * Set value
     *
     * @param integer $value
     *
     * @return Rate
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set valueOne
     *
     * @param integer $valueOne
     *
     * @return Rate
     */
    public function setValueOne($valueOne)
    {
        $this->valueOne = $valueOne;

        return $this;
    }

    /**
     * Get valueOne
     *
     * @return integer
     */
    public function getValueOne()
    {
        return $this->valueOne;
    }

    /**
     * Set valueTwo
     *
     * @param integer $valueTwo
     *
     * @return Rate
     */
    public function setValueTwo($valueTwo)
    {
        $this->valueTwo = $valueTwo;

        return $this;
    }

    /**
     * Get valueTwo
     *
     * @return integer
     */
    public function getValueTwo()
    {
        return $this->valueTwo;
    }

    /**
     * Set valueThree
     *
     * @param integer $valueThree
     *
     * @return Rate
     */
    public function setValueThree($valueThree)
    {
        $this->valueThree = $valueThree;

        return $this;
    }

    /**
     * Get valueThree
     *
     * @return integer
     */
    public function getValueThree()
    {
        return $this->valueThree;
    }

    /**
     * Set valueFour
     *
     * @param integer $valueFour
     *
     * @return Rate
     */
    public function setValueFour($valueFour)
    {
        $this->valueFour = $valueFour;

        return $this;
    }

    /**
     * Get valueFour
     *
     * @return integer
     */
    public function getValueFour()
    {
        return $this->valueFour;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Rate
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }
}
