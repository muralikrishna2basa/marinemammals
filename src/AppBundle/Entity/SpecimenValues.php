<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Config\Definition\Exception\Exception;

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
     * @ORM\Column(name="VALUE_FLAG", type="string", length=50, nullable=true)
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
     * @var \AppBundle\Entity\Spec2Events
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Spec2Events", inversedBy="values")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="S2E_SCN_SEQNO", referencedColumnName="SCN_SEQNO", nullable=false),
     *   @ORM\JoinColumn(name="S2E_ESE_SEQNO", referencedColumnName="ESE_SEQNO", nullable=false)
     * })
     */
    private $valueAssignable;

    /**
     * @var \AppBundle\Entity\ParameterMethods
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ParameterMethods", inversedBy="specimenValues")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="PMD_SEQNO", referencedColumnName="SEQNO", nullable=false)
     * })
     */
    private $pmdSeqno;

    /**
     * @var boolean
     */
    private $hasFlag;

    /**
     * @var boolean
     */
    private $valueRequired;

    /**
     * Constructor
     *
     * @param \AppBundle\Entity\ParameterMethods $pm
     * @param boolean $hasFlag
     * @param boolean $mustBeCompleted
     */
    public function __construct(\AppBundle\Entity\ParameterMethods $pm, $hasFlag, $mustBeCompleted)
    {
        $this->setPmdSeqno($pm);
        $this->setHasFlag($hasFlag);
        $this->setValueRequired($mustBeCompleted);
    }

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
        if($this->valueFlag === null ){
            $a=5;
        }
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
     * Set valueAssignable
     *
     * @param \AppBundle\Entity\ValueAssignable $valueAssignable
     * @return SpecimenValues
     * @throws \Exception
     */
    public function setValueAssignable(ValueAssignable $valueAssignable)
    {
        if (get_class($valueAssignable) !== 'AppBundle\Entity\Spec2Events') {
            throw new \Exception('type of $valueAssignable must be of type Spec2Events');
        } else {
            $this->valueAssignable = $valueAssignable;
            $valueAssignable->addValue($this);
            return $this;
        }
    }

    /**
     * Get valueAssignable
     *
     * @return \AppBundle\Entity\Spec2events
     */
    public function getvalueAssignable()
    {
        return $this->valueAssignable;
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
    public function getPmdName()
    {
        return $this->getPmdSeqno()->getName();
    }

    /**
     * @return boolean
     */
    public function getHasFlag()
    {
        return $this->hasFlag;
    }

    /**
     * @param boolean $hasFlag
     * @return SpecimenValues
     */
    public function setHasFlag($hasFlag)
    {
        $this->hasFlag = $hasFlag;
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
     * Get whether the value needs a flag. Any completed value needs a flag. Unwanted values don't need a flag. Note that flagged but empty values are legal.
     *
     * @return boolean
     */
    public function isValueFlagLegal()
    {
        if ($this->getHasFlag() && $this->getValueFlag() === null && $this->getValue() !== null) {
            return !$this->isValueUnwantedLegal(); //false
        } else {
            return true;
        }
    }

    /**
     * Get whether the value itself is unwanted. Determined dynamically based on the scnNumber of the attached specimen.
     * The value is legal if it is unwanted and if it is empty.
     * In this case, the whole specimenvalue should be deleted (all references to it are deleted, so the object can be garbage collected).
     *
     * @return boolean
     */
    public function isValueUnwantedLegal()
    {
        /*$unwanted = false;

        if ($this->getvalueAssignable() !== null && $this->getValue() !== null) {
            if ($this->getvalueAssignable()->getScnSeqno() !== null) {
                $unwanted = $this->getvalueAssignable()->getScnSeqno()->getScnNumber() > 1;
            }
        }
        return $unwanted;*/
        return !($this->isValueUnwanted() && $this->getValue() !== null);
    }

    /**
     * Get whether the value itself is unwanted. Determined dynamically based on
     * -the scnNumber of the attached specimen: the values are unwanted if the number of individuals in the specimen is more than 1.
     * In this case, the whole specimenvalue should be deleted (all references to it are deleted, so the object can be garbage collected).
     *
     * @return boolean
     */
    private function isValueUnwanted()
    {
        $unwanted = false;
        $s2e = $this->getvalueAssignable();
        if ($s2e !== null) {
            if ($s2e->getScnSeqno() !== null) {
                $unwanted = $s2e->getScnSeqno()->getScnNumber() > 1;
            }
        }
        return $unwanted;
    }

    /**
     * Get whether the value itself is unwanted. Determined dynamically based on the scnNumber of the attached specimen.
     * The value is legal if it is unwanted and if it is empty.
     * In this case, the whole specimenvalue should be deleted (all references to it are deleted, so the object can be garbage collected).
     *
     * @return boolean
     */
    public function isValueUnwantedLegal2()
    {
        return !($this->isValueUnwanted2() && $this->getValue() !== null);
    }

    /**
     * Get whether the value itself is unwanted. Determined dynamically based on
     * -the fact the specimen is alive or dead: the values are unwanted if they are pertaining the cause of death and the specimen is alive.
     * In this case, the whole specimenvalue should be deleted (all references to it are deleted, so the object can be garbage collected).
     *
     * @return boolean
     */
    private function isValueUnwanted2()
    {
        $unwanted = false;
        $s2e = $this->getvalueAssignable();
        if ($s2e !== null) {
            if ($s2e->getScnSeqno() !== null) {
                $moment = $s2e->getEseSeqno()->getEventDatetime();
                if ($moment) {
                    $pertainingToDeath=$this->getPmdSeqno()->isCodParameter();
                    $isAlive=$s2e->getScnSeqno()->isAliveAtMoment($moment);
                    if ($pertainingToDeath && $isAlive) {
                        $unwanted = true;
                    }
                }
            }
        }
        return $unwanted;
    }

    /**
     * Get whether the value itself must be completed.
     * unwanted values, whether empty or not are legal. However, them being completed is verified by $this->isValueUnwanted()
     *
     * @return boolean
     */
    public function isValueLegal()
    {
        return ($this->getValue() !== null && $this->getValueRequired()) ||
        ($this->getValue() === null && !$this->getValueRequired()) || ($this->getValue() !== null && !$this->getValueRequired()) || $this->isValueUnwanted() || $this->isValueUnwanted2();
    }

    public function delete()
    {
        $this->getvalueAssignable()->removeValue($this);
    }
}
