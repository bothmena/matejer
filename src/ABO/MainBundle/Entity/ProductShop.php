<?php

namespace ABO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ProductShop
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ABO\MainBundle\Entity\ProductShopRepository")
 */
class ProductShop
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
     * @ORM\ManyToOne(targetEntity="ABO\MainBundle\Entity\CategoryProduct")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categoryProduct;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=255,nullable=true)
     */
    private $reference;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=12, scale=2)
     * @Assert\GreaterThan(value="0")
     * @Assert\NotBlank()
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="discount", type="decimal", precision=5, scale=2)
     * @Assert\GreaterThanOrEqual(value = 0)
     * @Assert\LessThanOrEqual(value = 100)
     */
    private $discount;

    /**
     * @var integer
     *
     * @ORM\Column(name="warranty", type="integer")
     * @Assert\Type("integer")
     * @Assert\GreaterThanOrEqual(value = 0)
     */
    private $warranty;

    /**
     * @var string
     *
     * @ORM\Column(name="availability", type="string", length=5)
     * @Assert\Choice(choices = {"stock", "comnd", "avasn", "unava"}, message = "Choose a valid availability.")
     */
    private $availability;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     * @Assert\DateTime()
     */
    private $date;

    public function __construct() {
        
        $this->date = new \DateTime;
        $this->discount = 0;
        $this->warranty = 0;
    }
    
    public function fullname() {
        
        return $this->shop->getName().' | '.$this->categoryProduct->fullname();
    }
    
    public function transAvailability() {
        
        return 'matejer_offer.avai_choices.'.$this->availability;
    }
    
    public function availabilitySEO() {
        
        switch ($this->availability) {
            case 'stock':
                return 'InStock';
            case 'comnd':
                return 'PreOrder';
            case 'avasn':
                return 'OutOfStock';
            case 'unava':
                return 'OutOfStock';
            default:
                return 'InStock';
        }
    }

    public function classAvailability() {

        switch ($this->availability){
            case 'stock':
                return 'fa-thumbs-o-up';
            case 'comnd':
                return 'fa-calendar-check-o';
            case 'unava':
                return 'fa-times';
            case 'avasn':
                return 'fa-hourglass-end';
            default:
                return 'fa-times';
        }
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
     * @return ProductShop
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
     * Set price
     *
     * @param string $price
     *
     * @return ProductShop
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set discount
     *
     * @param string $discount
     *
     * @return ProductShop
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount
     *
     * @return string
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set warranty
     *
     * @param integer $warranty
     *
     * @return ProductShop
     */
    public function setWarranty($warranty)
    {
        $this->warranty = $warranty;

        return $this;
    }

    /**
     * Get warranty
     *
     * @return integer
     */
    public function getWarranty()
    {
        return $this->warranty;
    }

    /**
     * Set availability
     *
     * @param string $availability
     *
     * @return ProductShop
     */
    public function setAvailability($availability)
    {
        $this->availability = $availability;

        return $this;
    }

    /**
     * Get availability
     *
     * @return string
     */
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return ProductShop
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
     * Set shop
     *
     * @param \ABO\ShopBundle\Entity\Shop $shop
     *
     * @return ProductShop
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
     * Set categoryProduct
     *
     * @param \ABO\MainBundle\Entity\CategoryProduct $categoryProduct
     *
     * @return ProductShop
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
}
