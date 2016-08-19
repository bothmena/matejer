<?php

namespace ABO\ShopBundle\Entity;

use ABO\MainBundle\Entity\ProductShop;
use Doctrine\ORM\Mapping as ORM;

/**
 * CollectionProduct
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ABO\ShopBundle\Entity\CollectionProductRepository")
 */
class CollectionProduct
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
     * @ORM\ManyToOne(targetEntity="ABO\ShopBundle\Entity\Collection")
     * @ORM\JoinColumn(nullable=false)
     */
    private $collection;

    /**
     * @ORM\ManyToOne(targetEntity="ABO\MainBundle\Entity\ProductShop")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productShop;

    public function __construct(ProductShop $productShop = null, Collection $collection = null) {

        $this->collection = $collection;
        $this->productShop = $productShop;
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
     * Set collection
     *
     * @param \ABO\ShopBundle\Entity\Collection $collection
     *
     * @return CollectionProduct
     */
    public function setCollection(\ABO\ShopBundle\Entity\Collection $collection)
    {
        $this->collection = $collection;

        return $this;
    }

    /**
     * Get collection
     *
     * @return \ABO\ShopBundle\Entity\Collection
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * Set productShop
     *
     * @param \ABO\MainBundle\Entity\ProductShop $productShop
     *
     * @return CollectionProduct
     */
    public function setProductShop(\ABO\MainBundle\Entity\ProductShop $productShop)
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
