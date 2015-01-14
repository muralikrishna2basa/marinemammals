<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Medias
 *
 * @ORM\Table(name="MEDIAS", indexes={@ORM\Index(name="mda_ese_fk_i", columns={"ESE_SEQNO"}), @ORM\Index(name="mda_psn_fk_i", columns={"PSN_SEQNO"}), @ORM\Index(name="mda_oln_fk_i", columns={"OLN_NCY_ESE_SEQNO", "OLN_LTE_OGN_CODE", "OLN_LTE_SEQNO"})})
 * @ORM\Entity
 */
class Medias
{
    /**
     * @var boolean
     *
     * @ORM\Column(name="CONFIDENTIALITY", type="boolean", nullable=true)
     */
    private $confidentiality;

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
     * @ORM\Column(name="DESCRIPTION", type="string", length=4000, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="DISPLAY", type="string", length=1, nullable=true)
     */
    private $display;

    /**
     * @var string
     *
     * @ORM\Column(name="LOCATION", type="string", length=200, nullable=false)
     */
    private $location;

    /**
     * @var string
     *
     * @ORM\Column(name="MDA_TYPE", type="string", length=3, nullable=false)
     */
    private $mdaType;

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
     * @ORM\SequenceGenerator(sequenceName="MEDIAS_SEQ", allocationSize=1, initialValue=1)
     */
    private $seqno;

    /**
     * @var \AppBundle\Entity\Persons
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Persons")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="PSN_SEQNO", referencedColumnName="SEQNO")
     * })
     */
    private $psnSeqno;

    /**
     * @var \AppBundle\Entity\OrganLesions
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\OrganLesions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="OLN_NCY_ESE_SEQNO", referencedColumnName="NCY_ESE_SEQNO"),
     *   @ORM\JoinColumn(name="OLN_LTE_OGN_CODE", referencedColumnName="LTE_OGN_CODE"),
     *   @ORM\JoinColumn(name="OLN_LTE_SEQNO", referencedColumnName="LTE_SEQNO")
     * })
     */
    private $olnNcyEseSeqno;

    /**
     * @var \AppBundle\Entity\EventStates
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\EventStates")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ESE_SEQNO", referencedColumnName="SEQNO")
     * })
     */
    private $eseSeqno;



    /**
     * Set confidentiality
     *
     * @param boolean $confidentiality
     * @return Medias
     */
    public function setConfidentiality($confidentiality)
    {
        $this->confidentiality = $confidentiality;
    
        return $this;
    }

    /**
     * Get confidentiality
     *
     * @return boolean 
     */
    public function getConfidentiality()
    {
        return $this->confidentiality;
    }

    /**
     * Set creDat
     *
     * @param \DateTime $creDat
     * @return Medias
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
     * @return Medias
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
     * @return Medias
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
     * Set display
     *
     * @param string $display
     * @return Medias
     */
    public function setDisplay($display)
    {
        $this->display = $display;
    
        return $this;
    }

    /**
     * Get display
     *
     * @return string 
     */
    public function getDisplay()
    {
        return $this->display;
    }

    /**
     * Set location
     *
     * @param string $location
     * @return Medias
     */
    public function setLocation($location)
    {
        $this->location = $location;
    
        return $this;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set mdaType
     *
     * @param string $mdaType
     * @return Medias
     */
    public function setMdaType($mdaType)
    {
        $this->mdaType = $mdaType;
    
        return $this;
    }

    /**
     * Get mdaType
     *
     * @return string 
     */
    public function getMdaType()
    {
        return $this->mdaType;
    }

    /**
     * Set modDat
     *
     * @param \DateTime $modDat
     * @return Medias
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
     * @return Medias
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
     * Set psnSeqno
     *
     * @param \AppBundle\Entity\Persons $psnSeqno
     * @return Medias
     */
    public function setPsnSeqno(\AppBundle\Entity\Persons $psnSeqno = null)
    {
        $this->psnSeqno = $psnSeqno;
    
        return $this;
    }

    /**
     * Get psnSeqno
     *
     * @return \AppBundle\Entity\Persons 
     */
    public function getPsnSeqno()
    {
        return $this->psnSeqno;
    }

    /**
     * Set olnNcyEseSeqno
     *
     * @param \AppBundle\Entity\OrganLesions $olnNcyEseSeqno
     * @return Medias
     */
    public function setOlnNcyEseSeqno(\AppBundle\Entity\OrganLesions $olnNcyEseSeqno = null)
    {
        $this->olnNcyEseSeqno = $olnNcyEseSeqno;
    
        return $this;
    }

    /**
     * Get olnNcyEseSeqno
     *
     * @return \AppBundle\Entity\OrganLesions 
     */
    public function getOlnNcyEseSeqno()
    {
        return $this->olnNcyEseSeqno;
    }

    /**
     * Set eseSeqno
     *
     * @param \AppBundle\Entity\EventStates $eseSeqno
     * @return Medias
     */
    public function setEseSeqno(\AppBundle\Entity\EventStates $eseSeqno = null)
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
}
