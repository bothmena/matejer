<?php

namespace ABO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Color
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Color
{
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
     * @ORM\Column(name="name", type="string", length=31)
     * @Assert\Length(
     *      min = 2,
     *      max = 30,
     *      minMessage = "Color name must be at least {{ limit }} characters long",
     *      maxMessage = "Color name cannot be longer than {{ limit }} characters",
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=6,unique=true)
     * @Assert\Length(
     *      min = 6,
     *      max = 6,
     *      exactMessage="Color code must be 6 characters long ('#' not included)."
     * )
     */
    private $code;

    public function __construct(){
        
        $this->name = '';
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
     * @return Color
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
     * Set code
     *
     * @param string $code
     *
     * @return Color
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }
}
