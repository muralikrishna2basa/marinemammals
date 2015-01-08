<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Observations
 *
 * @ORM\Table(name="OBSERVATIONS", indexes={@ORM\Index(name="IDX_2EF312B895335730", columns={"PFM_SEQNO"}), @ORM\Index(name="IDX_2EF312B8A3C8473E", columns={"STN_SEQNO"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ObservationsRepository")
 */
class Observations
{
    /**
     * @var boolean
     *
     * @ORM\Column(name="CONFIDENTIALITY", type="boolean", nullable=true)
     */
    private $confidentiality;

    /**
     * @var string
     *
     * @ORM\Column(name="CPN_CODE", type="string", length=10, nullable=true)
     */
    private $cpnCode;

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
     * @var integer
     *
     * @ORM\Column(name="ID_ACCESS_TMP", type="integer", nullable=true)
     */
    private $idAccessTmp;

    /**
     * @var string
     *
     * @ORM\Column(name="LATITUDE", type="string", length=50, nullable=true)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="LAT_DEG", type="decimal", precision=25, scale=15, nullable=true)
     */
    private $latDeg;

    /**
     * @var string
     *
     * @ORM\Column(name="LONGITUDE", type="string", length=50, nullable=true)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="LON_DEG", type="decimal", precision=25, scale=15, nullable=true)
     */
    private $lonDeg;

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
     * @ORM\Column(name="OSN_TYPE", type="string", length=10, nullable=false)
     */
    private $osnType;

    /**
     * @var integer
     *
     * @ORM\Column(name="PRECISION_FLAG", type="integer", nullable=true)
     */
    private $precisionFlag;

    /**
     * @var integer
     *
     * @ORM\Column(name="SAMPLINGEFFORT", type="integer", nullable=true)
     */
    private $samplingeffort;

    /**
     * @var string
     *
     * @ORM\Column(name="WEBCOMMENTS_EN", type="string", length=250, nullable=true)
     */
    private $webcommentsEn;

    /**
     * @var string
     *
     * @ORM\Column(name="WEBCOMMENTS_FR", type="string", length=250, nullable=true)
     */
    private $webcommentsFr;

    /**
     * @var string
     *
     * @ORM\Column(name="WEBCOMMENTS_NL", type="string", length=250, nullable=true)
     */
    private $webcommentsNl;

    /**
     * @var \AppBundle\Entity\EventStates
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\EventStates")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ESE_SEQNO", referencedColumnName="SEQNO")
     * })
     */
    private $eseSeqno;

    /**
     * @var \AppBundle\Entity\Stations
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Stations")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="STN_SEQNO", referencedColumnName="SEQNO")
     * })
     */
    private $stnSeqno;

    /**
     * @var \AppBundle\Entity\Platforms
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Platforms")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="PFM_SEQNO", referencedColumnName="SEQNO")
     * })
     */
    private $pfmSeqno;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Sources", mappedBy="osnSeqno")
     */
    private $sreSeqno;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sreSeqno = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set confidentiality
     *
     * @param boolean $confidentiality
     * @return Observations
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
     * Set cpnCode
     *
     * @param string $cpnCode
     * @return Observations
     */
    public function setCpnCode($cpnCode)
    {
        $this->cpnCode = $cpnCode;
    
        return $this;
    }

    /**
     * Get cpnCode
     *
     * @return string 
     */
    public function getCpnCode()
    {
        return $this->cpnCode;
    }

    /**
     * Set creDat
     *
     * @param \DateTime $creDat
     * @return Observations
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
     * @return Observations
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
     * Set idAccessTmp
     *
     * @param integer $idAccessTmp
     * @return Observations
     */
    public function setIdAccessTmp($idAccessTmp)
    {
        $this->idAccessTmp = $idAccessTmp;
    
        return $this;
    }

    /**
     * Get idAccessTmp
     *
     * @return integer 
     */
    public function getIdAccessTmp()
    {
        return $this->idAccessTmp;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return Observations
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    
        return $this;
    }

    /**
     * Get latitude
     *
     * @return string 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set latDeg
     *
     * @param string $latDeg
     * @return Observations
     */
    public function setLatDeg($latDeg)
    {
        $this->latDeg = $latDeg;
    
        return $this;
    }

    /**
     * Get latDeg
     *
     * @return string 
     */
    public function getLatDeg()
    {
        return $this->latDeg;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return Observations
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    
        return $this;
    }

    /**
     * Get longitude
     *
     * @return string 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set lonDeg
     *
     * @param string $lonDeg
     * @return Observations
     */
    public function setLonDeg($lonDeg)
    {
        $this->lonDeg = $lonDeg;
    
        return $this;
    }

    /**
     * Get lonDeg
     *
     * @return string 
     */
    public function getLonDeg()
    {
        return $this->lonDeg;
    }

    /**
     * Set modDat
     *
     * @param \DateTime $modDat
     * @return Observations
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
     * @return Observations
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
     * Set osnType
     *
     * @param string $osnType
     * @return Observations
     */
    public function setOsnType($osnType)
    {
        $this->osnType = $osnType;
    
        return $this;
    }

    /**
     * Get osnType
     *
     * @return string 
     */
    public function getOsnType()
    {
        return $this->osnType;
    }

    /**
     * Set precisionFlag
     *
     * @param integer $precisionFlag
     * @return Observations
     */
    public function setPrecisionFlag($precisionFlag)
    {
        $this->precisionFlag = $precisionFlag;
    
        return $this;
    }

    /**
     * Get precisionFlag
     *
     * @return integer 
     */
    public function getPrecisionFlag()
    {
        return $this->precisionFlag;
    }

    /**
     * Set samplingeffort
     *
     * @param integer $samplingeffort
     * @return Observations
     */
    public function setSamplingeffort($samplingeffort)
    {
        $this->samplingeffort = $samplingeffort;
    
        return $this;
    }

    /**
     * Get samplingeffort
     *
     * @return integer 
     */
    public function getSamplingeffort()
    {
        return $this->samplingeffort;
    }

    /**
     * Set webcommentsEn
     *
     * @param string $webcommentsEn
     * @return Observations
     */
    public function setWebcommentsEn($webcommentsEn)
    {
        $this->webcommentsEn = $webcommentsEn;
    
        return $this;
    }

    /**
     * Get webcommentsEn
     *
     * @return string 
     */
    public function getWebcommentsEn()
    {
        return $this->webcommentsEn;
    }

    /**
     * Set webcommentsFr
     *
     * @param string $webcommentsFr
     * @return Observations
     */
    public function setWebcommentsFr($webcommentsFr)
    {
        $this->webcommentsFr = $webcommentsFr;
    
        return $this;
    }

    /**
     * Get webcommentsFr
     *
     * @return string 
     */
    public function getWebcommentsFr()
    {
        return $this->webcommentsFr;
    }

    /**
     * Set webcommentsNl
     *
     * @param string $webcommentsNl
     * @return Observations
     */
    public function setWebcommentsNl($webcommentsNl)
    {
        $this->webcommentsNl = $webcommentsNl;
    
        return $this;
    }

    /**
     * Get webcommentsNl
     *
     * @return string 
     */
    public function getWebcommentsNl()
    {
        return $this->webcommentsNl;
    }

    /**
     * Set eseSeqno
     *
     * @param \AppBundle\Entity\EventStates $eseSeqno
     * @return Observations
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
     * Set stnSeqno
     *
     * @param \AppBundle\Entity\Stations $stnSeqno
     * @return Observations
     */
    public function setStnSeqno(\AppBundle\Entity\Stations $stnSeqno = null)
    {
        $this->stnSeqno = $stnSeqno;
    
        return $this;
    }

    /**
     * Get stnSeqno
     *
     * @return \AppBundle\Entity\Stations 
     */
    public function getStnSeqno()
    {
        return $this->stnSeqno;
    }

    /**
     * Set pfmSeqno
     *
     * @param \AppBundle\Entity\Platforms $pfmSeqno
     * @return Observations
     */
    public function setPfmSeqno(\AppBundle\Entity\Platforms $pfmSeqno = null)
    {
        $this->pfmSeqno = $pfmSeqno;
    
        return $this;
    }

    /**
     * Get pfmSeqno
     *
     * @return \AppBundle\Entity\Platforms 
     */
    public function getPfmSeqno()
    {
        return $this->pfmSeqno;
    }

    /**
     * Add sreSeqno
     *
     * @param \AppBundle\Entity\Sources $sreSeqno
     * @return Observations
     */
    public function addSreSeqno(\AppBundle\Entity\Sources $sreSeqno)
    {
        $this->sreSeqno[] = $sreSeqno;
    
        return $this;
    }

    /**
     * Remove sreSeqno
     *
     * @param \AppBundle\Entity\Sources $sreSeqno
     */
    public function removeSreSeqno(\AppBundle\Entity\Sources $sreSeqno)
    {
        $this->sreSeqno->removeElement($sreSeqno);
    }

    /**
     * Get sreSeqno
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSreSeqno()
    {
        return $this->sreSeqno;
    }
}
