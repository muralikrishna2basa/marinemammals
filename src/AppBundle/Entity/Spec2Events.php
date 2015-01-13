<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Spec2Events SPEC2EVENTS
 *
 * @ORM\Table(name="SPEC2EVENTS", indexes={@ORM\Index(name="S2E_PK", columns={"SCN_SEQNO","ESE_SEQNO"}), @ORM\Index(name="S2E_ESE_FK_I", columns={"ESE_SEQNO"})})
 * @ORM\Entity
 */
class Spec2Events
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
     * @var \AppBundle\Entity\Specimens
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Specimens", inversedBy="spec2event")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="SCN_SEQNO", referencedColumnName="SEQNO")
     * })
     */
    private $scnSeqno;

    /**
     * @var \AppBundle\Entity\EventStates
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\EventStates", inversedBy="spec2event")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ESE_SEQNO", referencedColumnName="SEQNO")
     * })
     */
    private $eseSeqno;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\SpecimenValues", mappedBy="s2eScnSeqno")
     */
    private $specimenValues;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->specimenValues = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set creDat
     *
     * @param \DateTime $creDat
     * @return Event2persons
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
     * @return Event2persons
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
     * Set modDat
     *
     * @param \DateTime $modDat
     * @return Event2persons
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
     * @return Event2persons
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
     * Set scnSeqno
     *
     * @param \AppBundle\Entity\Specimens $scnSeqno
     * @return Spec2Events
     */
    public function setScnSeqno(\AppBundle\Entity\Specimens $scnSeqno)
    {
        $this->scnSeqno = $scnSeqno;

        return $this;
    }

    /**
     * Get scnSeqno
     *
     * @return \AppBundle\Entity\Specimens
     */
    public function getScnSeqno()
    {
        return $this->scnSeqno;
    }

    /**
     * Set eseSeqno
     *
     * @param \AppBundle\Entity\EventStates $eseSeqno
     * @return Event2persons
     */
    public function setEseSeqno(\AppBundle\Entity\EventStates $eseSeqno)
    {
        $this->eseSeqno = $eseSeqno;

        return $this;
    }

    /**
     * Get eseSeqno
     *
     * @return \AppBundle\Entity\EventStates
     */
    public function getEseSeqno()
    {
        return $this->eseSeqno;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSpecimenValues()
    {
        return $this->specimenValues;
    }

    /**
     * @param mixed $specimenValues
     * @return Spec2Events
     */
    public function setSpecimenValues($specimenValues)
    {
        $this->specimenValues = $specimenValues;
        return $this;
    }


}

