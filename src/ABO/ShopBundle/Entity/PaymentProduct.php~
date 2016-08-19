<?php

namespace ABO\ShopBundle\Entity;

use ABO\MainBundle\Entity\ProductShop;
use Doctrine\ORM\Mapping as ORM;

/**
 * PayementProduct
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ABO\ShopBundle\Entity\PaymentProductRepository")
 */
class PaymentProduct
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
     * @ORM\ManyToOne(targetEntity="ABO\ShopBundle\Entity\Payment")
     * @ORM\JoinColumn(nullable=false)
     */
    private $payment;

    /**
     * @ORM\ManyToOne(targetEntity="ABO\MainBundle\Entity\ProductShop")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productShop;

    public function __construct(ProductShop $productShop = null, Payment $payment = null) {

        $this->productShop = $productShop;
        $this->payment = $payment;
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
     * Set payment
     *
     * @param \ABO\ShopBundle\Entity\Payment $payment
     *
     * @return PaymentProduct
     */
    public function setPayment(Payment $payment)
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * Get payment
     *
     * @return \ABO\ShopBundle\Entity\Payment
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Set productShop
     *
     * @param \ABO\MainBundle\Entity\ProductShop $productShop
     *
     * @return PaymentProduct
     */
    public function setProductShop(ProductShop $productShop)
    {
        $this->productShop = $productShop;

        return $this;
    }

    /**
     * Get productShop
     *
     * @return \ABO\MainBundle\Entity\ProductShop
     */
    public function getProductShop()
    {
        return $this->productShop;
    }
}
