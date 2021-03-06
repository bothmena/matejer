<?php

namespace ABO\MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Image
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Image
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
     * @ORM\Column(name="entity", type="string", length=10)
     * @Assert\Choice(
     *     choices = { "user", "trademark","shop", "product" },
     *     message = "image.entity.choice",
     * )
     */
    private $entity;

    /**
     * @var string
     *
     * @ORM\Column(name="folder", type="string", length=32)
     */
    private $folder;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=10)
     * @Assert\Choice(
     *     choices = { "profile", "primary","secondary", "feature", "cover" },
     *     message = "image.type.choice",
     * )
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=45)
     */
    private $image;

    /**
     * @var boolean
     *
     * @ORM\Column(name="gcs", type="boolean")
     * @Assert\Type("bool")
     */
    private $gcs;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     * @Assert\DateTime()
     */
    private $date;
    
    /**
     * @Assert\File(
     *     maxSize = "3M",
     *     mimeTypes = {"image/png", "image/jpeg", "image/gif"},
     * )
     */
    protected $file;
    
    /**
     *  @Assert\All({
     *      @Assert\File(
     *          maxSize = "3M",
     *          mimeTypes = {"image/png", "image/jpeg", "image/gif"},
     *      )
     *  })
     * @var ArrayCollection
     */
    protected $files;
    
    public function __construct() {
        
        $this->gcs = false;
        $this->date = new \DateTime();
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
    
    public function getFileExt() {
        
        if (null === $this->file) {
            return null;
        }  else {
            $extension = $this->file->guessExtension();
            if(!$extension){
                $extension='bin';
            }
        }
            
        return $extension;
    }
    
    public function upload() {
        
        if (null === $this->file) {
            return;
        }
        
        $this->date = new \DateTime();
        $this->gcs = false;
        
        $this->file->move($this->getUploadRootDir(),$this->image);
    }
    
    public function getUploadDir() {
        
        return 'uploads/'.$this->entity.'/'.$this->folder;
    }
    public function getUploadRootDir() {
        
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    /**
     * Get rootSource
     *
     */
    public function getRootSource()
    {
        return $this->getUploadRootDir().'/'.$this->image;
    }

    /**
     * Get source
     *
     */
    public function getSource()
    {
        return $this->getUploadDir().'/'.$this->image;
    }
    
    /**
     * Set file
     *
     * @return Product
     */
    public function setFile($file) {
        
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     */
    public function getFile()
    {
        return $this->file;
    }
    
    /**
     * Set files
     *
     * @return Product
     */
    public function setFiles($files)
    {
        $this->files = $files;

        return $this;
    }

    /**
     * Get files
     *
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Set entity
     *
     * @param string $entity
     *
     * @return Image
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get entity
     *
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Set folder
     *
     * @param string $folder
     *
     * @return Image
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
     * Set type
     *
     * @param string $type
     *
     * @return Image
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
     * Set image
     *
     * @param string $image
     *
     * @return Image
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set gcs
     *
     * @param boolean $gcs
     *
     * @return Image
     */
    public function setGcs($gcs)
    {
        $this->gcs = $gcs;

        return $this;
    }

    /**
     * Get gcs
     *
     * @return boolean
     */
    public function getGcs()
    {
        return $this->gcs;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Image
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
}
