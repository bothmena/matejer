<?php

namespace ABO\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="ABO\MainBundle\Repository\MessageRepository")
 */
class Message
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="ABO\MainBundle\Entity\Conversation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $conversation;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     */
    private $message;
    
    /**
     * @var string
     *
     * @ORM\Column(name="sender", type="string", length=6)
     * // client or vendor
     */
    private $sender;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var bool
     *
     * @ORM\Column(name="anyRead", type="boolean")
     */
    private $anyRead;

    public function __construct() {
        
        $this->anyRead = false;
        $this->date = new \DateTime();
    }
    
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Message
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Message
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
     * Set anyRead
     *
     * @param boolean $anyRead
     *
     * @return Message
     */
    public function setAnyRead($anyRead)
    {
        $this->anyRead = $anyRead;

        return $this;
    }

    /**
     * Get anyRead
     *
     * @return bool
     */
    public function getAnyRead()
    {
        return $this->anyRead;
    }

    /**
     * Set sender
     *
     * @param string $sender
     *
     * @return Message
     */
    public function setSender($sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Get sender
     *
     * @return string
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set conversation
     *
     * @param \ABO\MainBundle\Entity\Conversation $conversation
     *
     * @return Message
     */
    public function setConversation(\ABO\MainBundle\Entity\Conversation $conversation)
    {
        $this->conversation = $conversation;

        return $this;
    }

    /**
     * Get conversation
     *
     * @return \ABO\MainBundle\Entity\Conversation
     */
    public function getConversation()
    {
        return $this->conversation;
    }
}
