<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Samples
 *
 * @ORM\Table(name="SAMPLES", indexes={@ORM\Index(name="spe_cln_fk_i", columns={"CLN_SEQNO"})})
 * @ORM\Entity
 */
class Samples
{
    /**
     * @var string
     *
     * @ORM\Column(name="ANALYZE_DEST", type="string", length=3, nullable=false)
     */
    private $analyzeDest;

    /**
     * @var string
     *
     * @ORM\Column(name="AVAILABILITY", type="string", length=20, nullable=true)
     */
    private $availability;

    /**
     * @var string
     *
     * @ORM\Column(name="CONSERVATION_MODE", type="string", length=10, nullable=false)
     */
    private $conservationMode;

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
     * @var string
     *
     * @ORM\Column(name="SPE_TYPE", type="string", length=3, nullable=false)
     */
    private $speType;

    /**
     * @var string
     *
     * @ORM\Column(name="SUBREF", type="string", length=10, nullable=true)
     */
    private $subref;

    /**
     * @var integer
     *
     * @ORM\Column(name="SEQNO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="SAMPLES_SEQ", allocationSize=1, initialValue=1)
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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\OrganLesions", mappedBy="speSeqno")
     */
    private $olnNcyEseSeqno;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\RequestLoans", mappedBy="speSeqno")
     */
    private $rlnSeqno;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->olnNcyEseSeqno = new \Doctrine\Common\Collections\ArrayCollection();
        $this->rlnSeqno = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set analyzeDest
     *
     * @param string $analyzeDest
     * @return Samples
     */
    public function setAnalyzeDest($analyzeDest)
    {
        $this->analyzeDest = $analyzeDest;
    
        return $this;
    }

    /**
     * Get analyzeDest
     *
     * @return string 
     */
    public function getAnalyzeDest()
    {
        return $this->analyzeDest;
    }

    /**
     * Set availability
     *
     * @param string $availability
     * @return Samples
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
     * Set conservationMode
     *
     * @param string $conservationMode
     * @return Samples
     */
    public function setConservationMode($conservationMode)
    {
        $this->conservationMode = $conservationMode;
    
        return $this;
    }

    /**
     * Get conservationMode
     *
     * @return string 
     */
    public function getConservationMode()
    {
        return $this->conservationMode;
    }

    /**
     * Set creDat
     *
     * @param \DateTime $creDat
     * @return Samples
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
     * @return Samples
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
     * @return Samples
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
     * @return Samples
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
     * Set speType
     *
     * @param string $speType
     * @return Samples
     */
    public function setSpeType($speType)
    {
        $this->speType = $speType;
    
        return $this;
    }

    /**
     * Get speType
     *
     * @return string 
     */
    public function getSpeType()
    {
        return $this->speType;
    }

    /**
     * Set subref
     *
     * @param string $subref
     * @return Samples
     */
    public function setSubref($subref)
    {
        $this->subref = $subref;
    
        return $this;
    }

    /**
     * Get subref
     *
     * @return string 
     */
    public function getSubref()
    {
        return $this->subref;
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
     * @return Samples
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
     * Add olnNcyEseSeqno
     *
     * @param \AppBundle\Entity\OrganLesions $olnNcyEseSeqno
     * @return Samples
     */
    public function addOlnNcyEseSeqno(\AppBundle\Entity\OrganLesions $olnNcyEseSeqno)
    {
        $this->olnNcyEseSeqno[] = $olnNcyEseSeqno;
    
        return $this;
    }

    /**
     * Remove olnNcyEseSeqno
     *
     * @param \AppBundle\Entity\OrganLesions $olnNcyEseSeqno
     */
    public function removeOlnNcyEseSeqno(\AppBundle\Entity\OrganLesions $olnNcyEseSeqno)
    {
        $this->olnNcyEseSeqno->removeElement($olnNcyEseSeqno);
    }

    /**
     * Get olnNcyEseSeqno
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOlnNcyEseSeqno()
    {
        return $this->olnNcyEseSeqno;
    }

    /**
     * Add rlnSeqno
     *
     * @param \AppBundle\Entity\RequestLoans $rlnSeqno
     * @return Samples
     */
    public function addRlnSeqno(\AppBundle\Entity\RequestLoans $rlnSeqno)
    {
        $this->rlnSeqno[] = $rlnSeqno;
    
        return $this;
    }

    /**
     * Remove rlnSeqno
     *
     * @param \AppBundle\Entity\RequestLoans $rlnSeqno
     */
    public function removeRlnSeqno(\AppBundle\Entity\RequestLoans $rlnSeqno)
    {
        $this->rlnSeqno->removeElement($rlnSeqno);
    }

    /**
     * Get rlnSeqno
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRlnSeqno()
    {
        return $this->rlnSeqno;
    }
}
