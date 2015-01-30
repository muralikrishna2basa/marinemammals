<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LesionValues
 *
 * @ORM\Table(name="LESION_VALUES", indexes={@ORM\Index(name="lve_pmd_fk_i", columns={"PMD_SEQNO"}), @ORM\Index(name="lve_oln_fk_i", columns={"OLN_NCY_ESE_SEQNO", "OLN_LTE_OGN_CODE", "OLN_LTE_SEQNO"})})
 * @ORM\Entity
 */
class LesionValues implements EntityValues
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
     * @ORM\Column(name="VALUE", type="string", length=50, nullable=false)
     */
    private $value;

    /**
     * @var string
     *
     * @ORM\Column(name="VALUE_FLAG", type="string", length=50, nullable=true)
     */
    private $valueFlag;

    /**
     * @var integer
     *
     * @ORM\Column(name="SEQNO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="LESION_VALUES_SEQ", allocationSize=1, initialValue=1)
     */
    private $seqno;

    /**
     * @var \AppBundle\Entity\ParameterMethods
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ParameterMethods")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="PMD_SEQNO", referencedColumnName="SEQNO", nullable=false)
     * })
     */
    private $pmdSeqno;

    /**
     * @var \AppBundle\Entity\OrganLesions
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\OrganLesions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="OLN_NCY_ESE_SEQNO", referencedColumnName="NCY_ESE_SEQNO", nullable=false),
     *   @ORM\JoinColumn(name="OLN_LTE_OGN_CODE", referencedColumnName="LTE_OGN_CODE", nullable=false),
     *   @ORM\JoinColumn(name="OLN_LTE_SEQNO", referencedColumnName="LTE_SEQNO", nullable=false)
     * })
     */
    private $olnNcyEseSeqno;



    /**
     * Set creDat
     *
     * @param \DateTime $creDat
     * @return LesionValues
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
     * @return LesionValues
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
     * @return LesionValues
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
     * @return LesionValues
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
     * Set value
     *
     * @param string $value
     * @return LesionValues
     */
    public function setValue($value)
    {
        $this->value = $value;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set valueFlag
     *
     * @param string $valueFlag
     * @return LesionValues
     */
    public function setValueFlag($valueFlag)
    {
        $this->valueFlag = $valueFlag;
    
        return $this;
    }

    /**
     * Get valueFlag
     *
     * @return string 
     */
    public function getValueFlag()
    {
        return $this->valueFlag;
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
     * Set pmdSeqno
     *
     * @param \AppBundle\Entity\ParameterMethods $pmdSeqno
     * @return LesionValues
     */
    public function setPmdSeqno(\AppBundle\Entity\ParameterMethods $pmdSeqno = null)
    {
        $this->pmdSeqno = $pmdSeqno;
    
        return $this;
    }

    /**
     * Get pmdSeqno
     *
     * @return \AppBundle\Entity\ParameterMethods 
     */
    public function getPmdSeqno()
    {
        return $this->pmdSeqno;
    }

    /**
     * Set olnNcyEseSeqno
     *
     * @param \AppBundle\Entity\OrganLesions $olnNcyEseSeqno
     * @return LesionValues
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
     * Get the name of the used parameter method's name
     *
     * @return string
     */
    public function getPmdName(){
        return $this->getPmdSeqno()->getName();
    }
}
