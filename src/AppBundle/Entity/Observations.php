<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Observations
 *
 * @ORM\Table(name="OBSERVATIONS", indexes={@ORM\Index(name="idx_stn_seqno", columns={"STN_SEQNO"}), @ORM\Index(name="idx_pfm_seqno", columns={"PFM_SEQNO"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ObservationsRepository")
 */
class Observations implements ValueAssignable
{
    /**
     * @var string
     *
     * @ORM\Column(name="CPN_CODE", type="string", length=20, nullable=true)
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
     * @var boolean
     *
     * @ORM\Column(name="ISCONFIDENTIAL", type="boolean", nullable=true)
     */
    private $isconfidential;

    /**
     * @var string
     *
     * @ORM\Column(name="LATITUDE", type="string", length=50, nullable=true)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="LAT_DEC", type="decimal", precision=25, scale=15, nullable=true)
     */
    private $latDec;

    /**
     * @var string
     *
     * @ORM\Column(name="LONGITUDE", type="string", length=50, nullable=true)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="LON_DEC", type="decimal", precision=25, scale=15, nullable=true)
     */
    private $lonDec;

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
     * @ORM\Column(name="PRECISION_FLAG", type="string", length=50, nullable=true)
     */
    private $precisionFlag;

    /**
     * @var string
     *
     * @ORM\Column(name="WEBCOMMENTS_EN", type="string", length=500, nullable=true)
     */
    private $webcommentsEn;

    /**
     * @var string
     *
     * @ORM\Column(name="WEBCOMMENTS_FR", type="string", length=500, nullable=true)
     */
    private $webcommentsFr;

    /**
     * @var string
     *
     * @ORM\Column(name="WEBCOMMENTS_NL", type="string", length=500, nullable=true)
     */
    private $webcommentsNl;

    /**
     * @var string
     *
     * @ORM\Column(name="AUTOPSY_REF", type="string", length=30, nullable=true)
     */
    private $autopsyRef;

    /**
     * @var boolean
     *
     * @ORM\Column(name="AUTOPSY_INDICATOR", type="boolean", nullable=true)
     */
    private $autopsyIndicator;

    /**
     * @var \AppBundle\Entity\EventStates
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\EventStates", inversedBy="observation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ESE_SEQNO", referencedColumnName="SEQNO", nullable=false)
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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Sources", inversedBy="osnSeqno")
     * @ORM\JoinTable(name="SOURCES2OBSERVATION", inverseJoinColumns={@ORM\JoinColumn(name="SRE_SEQNO", referencedColumnName="SEQNO")},
     *     joinColumns={@ORM\JoinColumn(name="OSN_SEQNO", referencedColumnName="ESE_SEQNO")})
     */
    private $sreSeqno;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ObservationValues", mappedBy="valueAssignable")
     */
    private $values;

    /**
     * @var \AppBundle\Entity\CgRefCodes
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CgRefCodes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="OSN_TYPE_REF", referencedColumnName="SEQNO")
     * })
     */
    private $osnTypeRef;

    /**
     * @var \AppBundle\Entity\CgRefCodes
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CgRefCodes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="SAMPLINGEFFORT_REF", referencedColumnName="SEQNO")
     * })
     */
    private $samplingeffortRef;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->isconfidential=false;
        $this->sreSeqno = new \Doctrine\Common\Collections\ArrayCollection();
        $this->values = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return string
     */
    public function getAutopsyRef()
    {
        return $this->autopsyRef;
    }

    /**
     * @param string $autopsyRef
     * @return Observations
     */
    public function setAutopsyRef($autopsyRef)
    {
        $this->autopsyRef = $autopsyRef;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getAutopsyIndicator()
    {
        return $this->autopsyIndicator;
    }

    /**
     * @param boolean $autopsyIndicator
     *  @return Observations
     */
    public function setAutopsyIndicator($autopsyIndicator)
    {
        $this->autopsyIndicator = $autopsyIndicator;
        return $this;
    }


    /**
     * Set isconfidential
     *
     * @param boolean $isconfidential
     * @return Observations
     */
    public function setIsconfidential($isconfidential)
    {
        $this->isconfidential = $isconfidential;
    
        return $this;
    }

    /**
     * Get isconfidential
     *
     * @return boolean 
     */
    public function getIsconfidential()
    {
        return $this->isconfidential;
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
     * Set latDec
     *
     * @param string $latDec
     * @return Observations
     */
    public function setLatDec($latDec)
    {
        $this->latDec = $latDec;
    
        return $this;
    }

    /**
     * Get latDec
     *
     * @return string 
     */
    public function getLatDec()
    {
        return $this->latDec;
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
     * Set lonDec
     *
     * @param string $lonDec
     * @return Observations
     */
    public function setLonDec($lonDec)
    {
        $this->lonDec = $lonDec;
    
        return $this;
    }

    /**
     * Get lonDec
     *
     * @return string 
     */
    public function getLonDec()
    {
        return $this->lonDec;
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
     * Set precisionFlag
     *
     * @param string $precisionFlag
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
     * @return string
     */
    public function getPrecisionFlag()
    {
        return $this->precisionFlag;
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
        $eseSeqno->setObservation($this);
    
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
    public function addSreSeqno(\AppBundle\Entity\Sources $sreSeqno = null)
    {
        if ($sreSeqno!== null and !$this->getSreSeqno()->contains($sreSeqno)) {
            $this->getSreSeqno()->add($sreSeqno);
            $sreSeqno->addOsnSeqno($this);
        }

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

    /**
     * Get single source
     *
     * @return \AppBundle\Entity\Sources
     */
    public function getSingleSource()
    {
        return $this->sreSeqno->first();
    }

    /**
     * Set single source
     *
     * @param \AppBundle\Entity\Sources $sreSeqno
     * @return Observations
     */
    public function setSingleSource(\AppBundle\Entity\Sources $sreSeqno = null)
    {
        $this->addSreSeqno($sreSeqno);
        return $this;
    }

    /**
     * @return CgRefCodes
     */
    public function getOsnTypeRef()
    {
        return $this->osnTypeRef;
    }

    /**
     * @param CgRefCodes $osnTypeRef
     * @return Observations
     */
    public function setOsnTypeRef($osnTypeRef)
    {
        $this->osnTypeRef = $osnTypeRef;
        return $this;
    }

    public function getOsnType(){
        return $this->getOsnTypeRef()->getRvLowValue();
    }

    /**
     * @return CgRefCodes
     */
    public function getSamplingeffortRef()
    {
        return $this->samplingeffortRef;
    }

    /**
     * @param CgRefCodes $samplingeffortRef
     * @return Observations
     */
    public function setSamplingeffortRef($samplingeffortRef)
    {
        $this->samplingeffortRef = $samplingeffortRef;
        return $this;
    }

    public function getSamplingeffort(){
        return $this->getSamplingeffortRef()->getRvLowValue();
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $values
     * @return Observations
     */
    public function setValues(\Doctrine\Common\Collections\Collection $values)
    {
        $this->values = $values;
        return $this;
    }

    /**
     * @param \AppBundle\Entity\EntityValues $value
     */
    public function addValue(EntityValues $value)
    {
        $this->getValues()->add($value);
    }

    public function removeValue(EntityValues $ev)
    {
        $this->getValues()->removeElement($ev);
    }

    public function isPrecisionFlagLegal(){
        return $this->isOnlyStationCompleted() || ($this->isCoordLegal() && $this->getPrecisionFlag() !== null) ;
    }

    private function isStationCompleted(){
        return $this->getStnSeqno() !== null;
    }

    private function isOnlyStationCompleted(){
        return $this->isStationCompleted() && $this->getlonDec() === null && $this->getlatDec() === null;
    }

    public function isStationOrCoordLegal() {
        if ($this->getlonDec() === null && $this->getlatDec() === null) {
            if (!$this->isStationCompleted()) {
                return false;
            }
            else return true;
        }
        else {
            if (!$this->isCoordLegal()) {
                return false;
            }
            else return true; // either empty or nonempty stations
        }
    }

    function isCoordLegal() {
        if (($this->getlonDec() === null && $this->getlatDec() !== null) || ($this->getlonDec() !== null && $this->getlatDec() === null)) {
            return false;
        }
        else return true;
    }

    public function getValueByKey($key){
        foreach($this->getValues() as $ev){
            if($ev->getPmdName()===$key){
                return $ev;
            }
        }
    }
}
