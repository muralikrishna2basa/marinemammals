<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stations
 *
 * @ORM\Table(name="STATIONS", indexes={@ORM\Index(name="idx_stn_pce_fk1", columns={"PCE_SEQNO"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\StationsRepository")
 */
class Stations
{
    /**
     * @var string
     *
     * @ORM\Column(name="AREA_TYPE", type="string", length=50, nullable=true)
     */
    private $areaType;

    /**
     * @var string
     *
     * @ORM\Column(name="CODE", type="string", length=50, nullable=true)
     */
    private $code;

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
     * @ORM\Column(name="DESCRIPTION", type="string", length=500, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="LATITUDE", type="string", length=20, nullable=true)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="LAT_DEC", type="decimal", precision=25, scale=12, nullable=true)
     */
    private $latDec;

    /**
     * @var string
     *
     * @ORM\Column(name="LONGITUDE", type="string", length=20, nullable=true)
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
     * @var integer
     *
     * @ORM\Column(name="SEQNO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="STATIONS_SEQ", allocationSize=1, initialValue=1)
     */
    private $seqno;

    /**
     * @var \AppBundle\Entity\Places
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Places")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="PCE_SEQNO", referencedColumnName="SEQNO", nullable=false)
     * })
     */
    private $pceSeqno;



    /**
     * Set areaType
     *
     * @param string $areaType
     * @return Stations
     */
    public function setAreaType($areaType)
    {
        $this->areaType = $areaType;
    
        return $this;
    }

    /**
     * Get areaType
     *
     * @return string 
     */
    public function getAreaType()
    {
        return $this->areaType;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return Stations
     */
    public function setCode($code)
    {
        $this->code = $code;
    
        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set creDat
     *
     * @param \DateTime $creDat
     * @return Stations
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
     * @return Stations
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
     * @return Stations
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
     * Set latitude
     *
     * @param string $latitude
     * @return Stations
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
     * @return Stations
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
     * @return Stations
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
     * @return Stations
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
     * @return Stations
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
     * @return Stations
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
     * Set pceSeqno
     *
     * @param \AppBundle\Entity\Places $pceSeqno
     * @return Stations
     */
    public function setPceSeqno(\AppBundle\Entity\Places $pceSeqno = null)
    {
        $this->pceSeqno = $pceSeqno;
    
        return $this;
    }

    /**
     * Get pceSeqno
     *
     * @return \AppBundle\Entity\Places 
     */
    public function getPceSeqno()
    {
        return $this->pceSeqno;
    }

    /**
     * Get fully Qualified Name
     *
     * @return \AppBundle\Entity\Places
     */
    public function getFullyQualifiedName()
    {
        return $this->getPceSeqno()->getName().' - '.$this->getCode().' ('.$this->getAreaType().')';
    }

    /**
     * Get fully Qualified Name
     *
     * @return \AppBundle\Entity\Places
     */
    public function getExtendedName()
    {
        return $this->getPceSeqno()->getName().' - '.$this->getCode();
    }

    /**
     * Get country the station is in
     *
     * @return string
     */
    public function getCountry()
    {
        if ($this->getPceSeqno() !== null){
            return $this->getPceSeqno()->getCountry();
        }
        else return '';

    }
}
