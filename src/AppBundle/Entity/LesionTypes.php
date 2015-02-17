<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LesionTypes
 *
 * @ORM\Table(name="LESION_TYPES", uniqueConstraints={@ORM\UniqueConstraint(name="lte_pk", columns={"OGN_CODE", "SEQNO"}), @ORM\UniqueConstraint(name="uk_ogn_processus", columns={"OGN_CODE", "PROCESSUS"})}, indexes={@ORM\Index(name="IDX_B8A6D97EFBE675E9", columns={"OGN_CODE"})})
 * @ORM\Entity
 */
class LesionTypes
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
     * @var string
     *
     * @ORM\Column(name="NAME", type="string", length=50, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="PROCESSUS", type="string", length=50, nullable=false)
     */
    private $processus;

    /**
     * @var integer
     *
     * @ORM\Column(name="SEQNO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="LESION_TYPES_SEQ", allocationSize=1, initialValue=1)
     */
    private $seqno;

    /**
     * @var \AppBundle\Entity\Organs
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="OGN_CODE", referencedColumnName="CODE", nullable=false)
     * })
     */
    private $ognCode;

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Set creDat
     *
     * @param \DateTime $creDat
     * @return LesionTypes
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
     * @return LesionTypes
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
     * @return LesionTypes
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
     * @return LesionTypes
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
     * Set name
     *
     * @param string $name
     * @return LesionTypes
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set processus
     *
     * @param string $processus
     * @return LesionTypes
     */
    public function setProcessus($processus)
    {
        $this->processus = $processus;
    
        return $this;
    }

    /**
     * Get processus
     *
     * @return string 
     */
    public function getProcessus()
    {
        return $this->processus;
    }

    /**
     * Set seqno
     *
     * @param integer $seqno
     * @return LesionTypes
     */
    public function setSeqno($seqno)
    {
        $this->seqno = $seqno;
    
        return $this;
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
     * Set ognCode
     *
     * @param \AppBundle\Entity\Organs $ognCode
     * @return LesionTypes
     */
    public function setOgnCode(\AppBundle\Entity\Organs $ognCode)
    {
        $this->ognCode = $ognCode;
    
        return $this;
    }

    /**
     * Get ognCode
     *
     * @return \AppBundle\Entity\Organs 
     */
    public function getOgnCode()
    {
        return $this->ognCode;
    }
}
