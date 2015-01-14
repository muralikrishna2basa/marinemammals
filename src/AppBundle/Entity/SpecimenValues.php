<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpecimenValues
 *
 * @ORM\Table(name="SPECIMEN_VALUES", indexes={@ORM\Index(name="sve_s2e_fk_i", columns={"S2E_SCN_SEQNO", "S2E_ESE_SEQNO"}), @ORM\Index(name="sve_pmd_fk_i", columns={"PMD_SEQNO"}), @ORM\Index(name="sve_ese_i", columns={"S2E_ESE_SEQNO"})})
 * @ORM\Entity
 */
class SpecimenValues implements EntityValues
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
     * @ORM\Column(name="DESCRIPTION", type="string", length=250, nullable=true)
     */
    private $description;

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
     * @ORM\Column(name="VALUE_FLAG", type="string", length=1, nullable=true)
     */
    private $valueFlag;

    /**
     * @var integer
     *
     * @ORM\Column(name="SEQNO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="SPECIMEN_VALUES_SEQ", allocationSize=1, initialValue=1)
     */
    private $seqno;

    /**
     * @var \AppBundle\Entity\Spec2events
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Spec2events", inversedBy="values")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="S2E_SCN_SEQNO", referencedColumnName="SCN_SEQNO"),
     *   @ORM\JoinColumn(name="S2E_ESE_SEQNO", referencedColumnName="ESE_SEQNO")
     * })
     */
    private $s2eScnSeqno;

    /**
     * @var \AppBundle\Entity\ParameterMethods
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ParameterMethods")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="PMD_SEQNO", referencedColumnName="SEQNO")
     * })
     */
    private $pmdSeqno;



    /**
     * Set creDat
     *
     * @param \DateTime $creDat
     * @return SpecimenValues
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
     * @return SpecimenValues
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
     * @return SpecimenValues
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
     * Set modDat
     *
     * @param \DateTime $modDat
     * @return SpecimenValues
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
     * @return SpecimenValues
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
     * @return SpecimenValues
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
     * @return SpecimenValues
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
     * Set s2eScnSeqno
     *
     * @param \AppBundle\Entity\Spec2events $s2eScnSeqno
     * @return SpecimenValues
     */
    public function setS2eScnSeqno(\AppBundle\Entity\Spec2events $s2eScnSeqno = null)
    {
        $this->s2eScnSeqno = $s2eScnSeqno;
    
        return $this;
    }

    /**
     * Get s2eScnSeqno
     *
     * @return \AppBundle\Entity\Spec2events 
     */
    public function getS2eScnSeqno()
    {
        return $this->s2eScnSeqno;
    }

    /**
     * Set pmdSeqno
     *
     * @param \AppBundle\Entity\ParameterMethods $pmdSeqno
     * @return SpecimenValues
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
     * Get the name of the used parameter method's name
     *
     * @return string
     */
    public function getPmdName(){
        return $this->getPmdSeqno()->getName();
    }
}
