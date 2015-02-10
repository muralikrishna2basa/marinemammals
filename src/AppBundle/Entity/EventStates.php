<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Exception\InvalidArgumentException;
use \DateTime;

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
     * @ORM\Column(name="EVENT_DATETIME_FLAG", type="string", length=50, nullable=false)
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
     * @ORM\SequenceGenerator(sequenceName="EVENT_STATES_SEQ", allocationSize=1, initialValue=1)
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
    private $spec2events;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Event2Persons", mappedBy="eseSeqno")
     */
    private $event2Persons;

    const GATHERED = 'GB';

    const OBSERVED = 'OB';

    //private $date;

    //private $time;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->event2Persons = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return \AppBundle\Entity\Spec2Events
     */
    public function getSpec2Events()
    {
        return $this->spec2events;
    }

    /**
     * @param \AppBundle\Entity\Spec2Events $spec2events
     * @return EventStates
     */
    public function setSpec2Events($spec2events)
    {
        $this->spec2events = $spec2events;
        $spec2events->setEseSeqno($this);
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvent2Persons()
    {
        return $this->event2Persons;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $event2Persons
     * @return EventStates
     */
    public function setEvent2Persons($event2Persons)
    {
        $this->event2Persons = $event2Persons;
        return $this;
    }

    /**
     * @param \AppBundle\Entity\Event2Persons $event2Person
     */
    public function addEvent2Persons($event2Person)
    {
        if (!$this->getEvent2Persons()->contains($event2Person)) {
            $event2Person->addEvent($this);
            $this->getEvent2Persons()->add($event2Person);
        }
    }


    public function removeEvent2Persons($event2Person)
    {
        if ($this->getEvent2Persons()->contains($event2Person)) {
            $this->getEvent2Persons()->removeElement($event2Person);
        }
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $event2persons
     * @return EventStates
     */
    public function setObservers(\Doctrine\Common\Collections\Collection $event2persons)
    {
        // foreach ($event2persons as $e2p) {
        //     $e2p->setE2pType(OBSERVED);
        // }
        $this->event2Persons = new \Doctrine\Common\Collections\ArrayCollection(array_merge($this->getEvent2Persons()->toArray(), $event2persons->toArray()));
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getObservers()
    {
        return $this->getEvent2Persons()->filter(
            function ($entry) {
                return $entry->getE2pType() == EventStates::OBSERVED;
            }
        );
    }

    /**
     * @param \AppBundle\Entity\Event2Persons $event2Person
     */
    public function addObservers($event2Person)
    {
        //$event2Person->setE2pType(EventStates::OBSERVED);
        if (!$this->getEvent2Persons()->contains($event2Person)) {
            $event2Person->setEseSeqno($this);
            $this->getEvent2Persons()->add($event2Person);
        }
    }

    /**
     * @param \AppBundle\Entity\Event2Persons $event2Person
     */
    public function removeObservers($event2Person)
    {
        if ($this->getEvent2Persons()->contains($event2Person)) {
            $this->getEvent2Persons()->removeElement($event2Person);
        }
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $event2persons
     * @return EventStates
     */
    public function setGatherers(\Doctrine\Common\Collections\Collection $event2persons)
    {
        // foreach ($event2persons as $e2p) {
        //     $e2p->setE2pType(EventStates::GATHERED);
        // }
        $this->event2Persons = new \Doctrine\Common\Collections\ArrayCollection(array_merge($this->getEvent2Persons()->toArray(), $event2persons->toArray()));
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGatherers()
    {
        return $this->getEvent2Persons()->filter(
            function ($entry) {
                return $entry->getE2pType() == EventStates::GATHERED;
            }
        );
    }

    /**
     * @param \AppBundle\Entity\Event2Persons $event2Person
     */
    public function addGatherers($event2Person)
    {
        //$event2Person->setE2pType(EventStates::GATHERED);
        if (!$this->getEvent2Persons()->contains($event2Person)) {
            $event2Person->setEseSeqno($this);
            $this->getEvent2Persons()->add($event2Person);
        }
    }

    /**
     * @param \AppBundle\Entity\Event2Persons $event2Person
     */
    public function removeGatherers($event2Person)
    {
        if ($this->getEvent2Persons()->contains($event2Person)) {
            $this->getEvent2Persons()->removeElement($event2Person);
        }
    }

    /**
     * @param string $time
     * @return EventStates
     */
    public function setTime($time)
    {
        $match = $this->isTime($time);
        if ($this->getEventDatetime()) {
            if ($match) {
                //$this->time=$time;
                $this->getEventDatetime()->setTime($match[1], $match[2]);
            } else {
               // throw new InvalidArgumentException("The provided time is not in hh:mm format.");
            }
        }
       /* else{
            throw new InvalidArgumentException("Time cannot be set when the date is null.");
        }*/
        return $this;
    }

    /**
     * @return string
     */
    public function getTime()
    {
        return $this->getEventDatetime()->format("H:i");
    }

    /**
     * @param string $time
     * @return boolean
     */
    public static function isTime($time)
    {
        $match = array();
        if (preg_match('/^([0-9]{1,2}):([0-9]{2})/', $time, $match) === 1) {
            return $match;
        } else return null;
    }

    /**
     * @param string $date
     * @return EventStates
     */
    public function setDate($date)
    {

        $dt = \DateTime::createFromFormat('d/m/Y', $date);
        if($dt !== null){
            //$this->date=$date;
            $this->setEventDatetime($dt);
            $this->getEventDatetime()->setTime(0,0,0);
        }
        //$d = $dt->format("d");
        //$m = $dt->format("m");
        //$y = $dt->format("y");
        //$this->getEventDatetime()->setDate($y, $m, $d);
        return $this;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->getEventDatetime()->format('d/m/Y');
    }

    /**
     * @return boolean
     */
/*    public function isDateLegal()
    {
        return $this->canHaveAsDate($this->getEventDatetime());
    }*/

    /**
     * @param string $date
     * @return boolean
     */
/*    public function canHaveAsDate($date)
    {
        return $date >= new DateTime('1900-01-01') and $date <= new DateTime('now');
    }*/

}
