<?php

namespace ABO\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Payement
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ABO\ShopBundle\Entity\PaymentRepository")
 */
class Payment
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
    * @ORM\ManyToOne(targetEntity="ABO\ShopBundle\Entity\Shop")
    * @ORM\JoinColumn(nullable=false)
    */
    private $shop;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=61,nullable=true)
     * @Assert\Length(
     *      max = 60,
     *      maxMessage = "Payment name cannot be longer than {{ limit }} characters",
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="addedValue", type="decimal", precision=5, scale=2)
     * @Assert\Range(
     *      min = 0,
     *      max = 100,
     *      minMessage = "Added Value must be at least {{ limit }}%",
     *      maxMessage = "Added Value cannot be greater than {{ limit }}%"
     * )
     */
    private $addedValue;

    /**
     * @var string
     *
     * @ORM\Column(name="advance", type="decimal", precision=5, scale=2)
     * @Assert\Range(
     *      min = 0,
     *      max = 100,
     *      minMessage = "Advanced Value must be at least {{ limit }}%",
     *      maxMessage = "Advanced Value cannot be greater than {{ limit }}%"
     * )
     */
    private $advance;

    /**
     * @var integer
     *
     * @ORM\Column(name="month", type="smallint")
     * @Assert\Type("integer")
     * @Assert\Range(
     *      min = 1,
     *      max = 360,
     *      minMessage = "Months number must be at least {{ limit }}",
     *      maxMessage = "Months number must be less than {{ limit }}"
     * )
     */
    private $month;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     * @Assert\Type("bool")
     */
    private $active;

    public function __construct() {
        
        $this->active = true;
    }
    
    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        
        $msg = '';
        if( !empty($this->name) )
            $msg = $this->name.' : ';
        $msg = $msg.'+'.number_format($this->addedValue, 2, '.', ' ').'% / '.number_format($this->advance, 2, '.', ' ').'% / '.$this->month;
        return $msg;
    }

    /**
     * Get exempleDesc
     *
     * @return string
     */
    public function getExempleDescription($price) {

        if(!empty($price)){
            $newPrice = $price + $price * $this->getAddedValue() / 100;
            $advance = $newPrice * $this->getAdvance() / 100;
            $perMth = ( $newPrice - $advance ) / $this->getMonth();
            return ['advance' => $advance, 'perMonth' => $perMth];
        }else
            return ['advance' => '', 'perMonth' => ''];
    }

    /**
     * Get nameOrDescription
     *
     * @return string
     */
    public function getNameOrDescription() {

        if(!empty($this->name))
            return $this->name;
        else
            return 'matejer_payment.this_payment';

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
     * @return Payment
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
     * Set addedValue
     *
     * @param string $addedValue
     *
     * @return Payment
     */
    public function setAddedValue($addedValue)
    {
        $this->addedValue = $addedValue;

        return $this;
    }

    /**
     * Get addedValue
     *
     * @return string
     */
    public function getAddedValue()
    {
        return $this->addedValue;
    }

    /**
     * Set advance
     *
     * @param string $advance
     *
     * @return Payment
     */
    public function setAdvance($advance)
    {
        $this->advance = $advance;

        return $this;
    }

    /**
     * Get advance
     *
     * @return string
     */
    public function getAdvance()
    {
        return $this->advance;
    }

    /**
     * Set month
     *
     * @param integer $month
     *
     * @return Payment
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * Get month
     *
     * @return integer
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Payment
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set shop
     *
     * @param \ABO\ShopBundle\Entity\Shop $shop
     *
     * @return Payment
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
}
