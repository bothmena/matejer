<?php

namespace ABO\ShopBundle\Entity;

use ABO\MainBundle\Entity\RateStat;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Shop
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ABO\ShopBundle\Entity\ShopRepository")
 */
class Shop {
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\OneToOne(targetEntity="ABO\MainBundle\Entity\Address",cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $address;

    /**
     * @ORM\OneToOne(targetEntity="ABO\MainBundle\Entity\RateStat",cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $rateStat;

    //@ORM\JoinColumn(nullable=false)
    /**
     * @ORM\ManyToOne(targetEntity="ABO\MainBundle\Entity\Image")
     */
    private $image;

    //@ORM\JoinColumn(nullable=false)
    /**
     * @ORM\ManyToOne(targetEntity="ABO\MainBundle\Entity\Image")
     */
    private $cover;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=61)
     * @Assert\Length(
     *      min = 2,
     *      max = 60,
     *      minMessage = "Your shop name must be at least {{ limit }} characters long",
     *      maxMessage = "Your shop name cannot be longer than {{ limit }} characters",
     * )
     */
    private $name;
    
    /**
    * @Gedmo\Slug(fields={"name"})
    * @ORM\Column(length=80, unique=true)
    */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string", length=3)
     */
    private $currency;

    /**
     * @var string
     *
     * @ORM\Column(name="folder", type="string", length=255, unique=true)
     */
    private $folder;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="inscriptionDate", type="datetime")
     * @Assert\DateTime()
     */
    private $inscriptionDate;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\Length(
     *      min = 45,
     *      max = 1000,
     *      minMessage = "Your shop description must be at least {{ limit }} characters long",
     *      maxMessage = "Your shop description cannot be longer than {{ limit }} characters",
     * )
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=255, nullable=true)
     * @Assert\Url(
     *    checkDNS = true,
     *    message = "The url '{{ value }}' is not a valid url",
     *    protocols = {"http", "https"}
     * )
     */
    private $website;

    /**
     * @var string
     *
     * @ORM\Column(name="slogan", type="string", length=255)
     * @Assert\Length(
     *      min = 10,
     *      max = 255,
     *      minMessage = "Your shop slogan must be at least {{ limit }} characters long",
     *      maxMessage = "Your shop slogan cannot be longer than {{ limit }} characters",
     * )
     */
    private $slogan;

    /**
     * @var integer
     *
     * @ORM\Column(name="clientNb", type="integer", options={"unsigned"=true})
     */
    private $clientNb;

    /**
     * @var integer
     *
     * @ORM\Column(name="offerNb", type="integer", options={"unsigned"=true})
     */
    private $offerNb;
    
    public function __construct() {
        
        $this->rateStat = new RateStat();
        $this->inscriptionDate = new \DateTime;
        $this->website = '';
        $this->description = '';
        $this->currency = 'tnd';
        $this->clientNb = 0;
        $this->offerNb = 0;
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
    
    public function getClassName() {
        
        return 'ShopEntity';
    }
    
    public function transCurrency() {
        
        return 'matejer_currency.'.$this->currency;
    }

    public function transExCurrency() {

        return 'matejer_ex_currency.'.$this->currency;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Shop
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
     * @return Shop
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
     * Set currency
     *
     * @param string $currency
     *
     * @return Shop
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set folder
     *
     * @param string $folder
     *
     * @return Shop
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
     * Set inscriptionDate
     *
     * @param \DateTime $inscriptionDate
     *
     * @return Shop
     */
    public function setInscriptionDate($inscriptionDate)
    {
        $this->inscriptionDate = $inscriptionDate;

        return $this;
    }

    /**
     * Get inscriptionDate
     *
     * @return \DateTime
     */
    public function getInscriptionDate()
    {
        return $this->inscriptionDate;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Shop
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
     * Set website
     *
     * @param string $website
     *
     * @return Shop
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set slogan
     *
     * @param string $slogan
     *
     * @return Shop
     */
    public function setSlogan($slogan)
    {
        $this->slogan = $slogan;

        return $this;
    }

    /**
     * Get slogan
     *
     * @return string
     */
    public function getSlogan()
    {
        return $this->slogan;
    }

    /**
     * Set clientNb
     *
     * @param integer $clientNb
     *
     * @return Shop
     */
    public function setClientNb($clientNb)
    {
        $this->clientNb = $clientNb;

        return $this;
    }

    /**
     * Get clientNb
     *
     * @return integer
     */
    public function getClientNb()
    {
        return $this->clientNb;
    }

    /**
     * Set address
     *
     * @param \ABO\MainBundle\Entity\Address $address
     *
     * @return Shop
     */
    public function setAddress(\ABO\MainBundle\Entity\Address $address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \ABO\MainBundle\Entity\Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set rateStat
     *
     * @param \ABO\MainBundle\Entity\RateStat $rateStat
     *
     * @return Shop
     */
    public function setRateStat(\ABO\MainBundle\Entity\RateStat $rateStat)
    {
        $this->rateStat = $rateStat;

        return $this;
    }

    /**
     * Get rateStat
     *
     * @return \ABO\MainBundle\Entity\RateStat
     */
    public function getRateStat()
    {
        return $this->rateStat;
    }

    /**
     * Set image
     *
     * @param \ABO\MainBundle\Entity\Image $image
     *
     * @return Shop
     */
    public function setImage(\ABO\MainBundle\Entity\Image $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \ABO\MainBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set offerNb
     *
     * @param integer $offerNb
     *
     * @return Shop
     */
    public function setOfferNb($offerNb)
    {
        $this->offerNb = $offerNb;

        return $this;
    }

    /**
     * Get offerNb
     *
     * @return integer
     */
    public function getOfferNb()
    {
        return $this->offerNb;
    }

    /**
     * Set cover
     *
     * @param \ABO\MainBundle\Entity\Image $cover
     *
     * @return Shop
     */
    public function setCover(\ABO\MainBundle\Entity\Image $cover)
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * Get cover
     *
     * @return \ABO\MainBundle\Entity\Image
     */
    public function getCover()
    {
        return $this->cover;
    }
}
