<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ObservationValues
 *
 * @ORM\Table(name="OBSERVATION_VALUES", indexes={@ORM\Index(name="idx_ov_pmd_fk", columns={"PMD_SEQNO"}), @ORM\Index(name="idx_ov_ese_fk", columns={"ESE_SEQNO"})})
 * @ORM\Entity
 */
class ObservationValues implements EntityValues
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
     * @ORM\SequenceGenerator(sequenceName="OBSERVATION_VALUES_SEQ", allocationSize=1, initialValue=1)
     */
    private $seqno;

    /**
     * @var \AppBundle\Entity\ParameterMethods
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ParameterMethods", inversedBy="observationValues")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="PMD_SEQNO", referencedColumnName="SEQNO", nullable=false)
     * })
     */
    private $pmdSeqno;

    /**
     * @var \AppBundle\Entity\Observations
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Observations", inversedBy="values")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ESE_SEQNO", referencedColumnName="ESE_SEQNO", nullable=false)
     * })
     */
    private $eseSeqno;

    /**
     * @var boolean
     *
     */
    private $valueFlagRequired;

    /**
     * @var boolean
     */
    private $valueRequired;

    /**
     * Set creDat
     *
     * @param \DateTime $creDat
     * @return ObservationValues
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
     * @return ObservationValues
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
     * @return ObservationValues
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
     * @return ObservationValues
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
     * @return ObservationValues
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
     * @return ObservationValues
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
     * @return ObservationValues
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
     * Set eseSeqno
     *
     * @param \AppBundle\Entity\Observations $eseSeqno
     * @return ObservationValues
     */
    public function setEseSeqno(\AppBundle\Entity\Observations $eseSeqno = null)
    {
        $this->eseSeqno = $eseSeqno;
        $eseSeqno->addValue($this);
        return $this;
    }

    /**
     * Get eseSeqno
     *
     * @return \AppBundle\Entity\Observations 
     */
    public function getEseSeqno()
    {
        return $this->eseSeqno;
    }

    /**
     * Get the name of the used parameter method's name
     *
     * @return string
     */
    public function getPmdName(){
        return $this->getPmdSeqno()->getName();
    }

    /**
     * @return boolean
     */
    public function getValueFlagRequired()
    {
        return $this->valueFlagRequired;
    }

    /**
     * @param boolean $valueFlagRequired
     * @return SpecimenValues
     */
    public function setValueFlagRequired($valueFlagRequired)
    {
        $this->valueFlagRequired = $valueFlagRequired;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getValueRequired()
    {
        return $this->valueRequired;
    }

    /**
     * @param boolean $valueRequired
     * @return SpecimenValues
     */
    public function setValueRequired($valueRequired)
    {
        $this->valueRequired = $valueRequired;
        return $this;
    }

    /**
     * Get whether the value is legal, i.e. has a flag. Note that flagged but empty values are legal!
     *
     * @return boolean
     */
    public function isValueFlagLegal()
    {
        if ($this->getValueFlagRequired() && $this->getValueFlag() === NULL && $this->getValue() !== NULL) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get whether the value itself is wanted.
     *
     * @return boolean
     */
    public function isValueUnwantedLegal()
    {
        return false;
    }

    /**
     * Get whether the value itself must be completed.
     *
     * @return boolean
     */
    public function isValueLegal(){
        return $this->getValueRequired() && !$this->isValueUnwantedLegal();
    }
}
