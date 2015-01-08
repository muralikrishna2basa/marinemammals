<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventStates
 *
 * @ORM\Table(name="EVENT_STATES", indexes={@ORM\Index(name="IDX_59D47093A0562FD1", columns={"CLN_SEQNO"})})
 * @ORM\Entity
 */
class EventStates
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="CRE_DAT", type="datetime", nullable=true)
     */
    private $creDat;

    /**
     * @var string
     *
     * @ORM\Column(name="CRE_USER", type="string", length=30, nullable=true)
     */
    private $creUser;

    /**
     * @var string
     *
     * @ORM\Column(name="DESCRIPTION", type="string", length=4000, nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="EVENT_DATETIME", type="datetime", nullable=false)
     */
    private $eventDatetime;

    /**
     * @var string
     *
     * @ORM\Column(name="EVENT_DATETIME_FLAG", type="string", length=1, nullable=false)
     */
    private $eventDatetimeFlag;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="MOD_DAT", type="datetime", nullable=true)
     */
    private $modDat;

    /**
     * @var string
     *
     * @ORM\Column(name="MOD_USER", type="string", length=30, nullable=true)
     */
    private $modUser;

    /**
     * @var integer
     *
     * @ORM\Column(name="SEQNO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="EVENT_STATES_SEQNO_seq", allocationSize=1, initialValue=1)
     */
    private $seqno;

    /**
     * @var \AppBundle\Entity\ContainerLocalizations
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ContainerLocalizations")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CLN_SEQNO", referencedColumnName="SEQNO")
     * })
     */
    private $clnSeqno;


    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Spec2Events", mappedBy="eseSeqno")
     **/
    private $spec2event;



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->scnSeqno = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set creDat
     *
     * @param \DateTime $creDat
     * @return EventStates
     */
    public function setCreDat($creDat)
    {
        $this->creDat = $creDat;
    
        return $this;
    }

    /**
     * Get creDat
     *
     * @return \DateTime 
     */
    public function getCreDat()
    {
        return $this->creDat;
    }

    /**
     * Set creUser
     *
     * @param string $creUser
     * @return EventStates
     */
    public function setCreUser($creUser)
    {
        $this->creUser = $creUser;
    
        return $this;
    }

    /**
     * Get creUser
     *
     * @return string 
     */
    public function getCreUser()
    {
        return $this->creUser;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return EventStates
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
     * Set eventDatetime
     *
     * @param \DateTime $eventDatetime
     * @return EventStates
     */
    public function setEventDatetime($eventDatetime)
    {
        $this->eventDatetime = $eventDatetime;
    
        return $this;
    }

    /**
     * Get eventDatetime
     *
     * @return \DateTime 
     */
    public function getEventDatetime()
    {
        return $this->eventDatetime;
    }

    /**
     * Set eventDatetimeFlag
     *
     * @param string $eventDatetimeFlag
     * @return EventStates
     */
    public function setEventDatetimeFlag($eventDatetimeFlag)
    {
        $this->eventDatetimeFlag = $eventDatetimeFlag;
    
        return $this;
    }

    /**
     * Get eventDatetimeFlag
     *
     * @return string 
     */
    public function getEventDatetimeFlag()
    {
        return $this->eventDatetimeFlag;
    }

    /**
     * Set modDat
     *
     * @param \DateTime $modDat
     * @return EventStates
     */
    public function setModDat($modDat)
    {
        $this->modDat = $modDat;
    
        return $this;
    }

    /**
     * Get modDat
     *
     * @return \DateTime 
     */
    public function getModDat()
    {
        return $this->modDat;
    }

    /**
     * Set modUser
     *
     * @param string $modUser
     * @return EventStates
     */
    public function setModUser($modUser)
    {
        $this->modUser = $modUser;
    
        return $this;
    }

    /**
     * Get modUser
     *
     * @return string 
     */
    public function getModUser()
    {
        return $this->modUser;
    }

    /**
     * Get seqno
     *
     * @return integer 
     */
    public function getSeqno()
    {
        return $this->seqno;
    }

    /**
     * Set clnSeqno
     *
     * @param \AppBundle\Entity\ContainerLocalizations $clnSeqno
     * @return EventStates
     */
    public function setClnSeqno(\AppBundle\Entity\ContainerLocalizations $clnSeqno = null)
    {
        $this->clnSeqno = $clnSeqno;
    
        return $this;
    }

    /**
     * Get clnSeqno
     *
     * @return \AppBundle\Entity\ContainerLocalizations 
     */
    public function getClnSeqno()
    {
        return $this->clnSeqno;
    }

    /**
     * Get spec2event
     *
     * @return \AppBundle\Entity\Spec2Events
     */
    public function getSpec2event()
    {
        return $this->spec2event;
    }
}
