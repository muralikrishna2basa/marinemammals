<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ParameterMethods
 *
 * @ORM\Table(name="PARAMETER_METHODS", uniqueConstraints={@ORM\UniqueConstraint(name="uk_name", columns={"NAME"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ParameterMethodsRepository")
 */
class ParameterMethods
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
     * @ORM\Column(name="DESCRIPTION", type="string", length=100, nullable=false)
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
     * @ORM\Column(name="NAME", type="string", length=70, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="ORIGIN", type="string", length=50, nullable=false)
     */
    private $origin;

    /**
     * @var string
     *
     * @ORM\Column(name="UNIT", type="string", length=10, nullable=true)
     */
    private $unit;

    /**
     * @var string
     *
     * @ORM\Column(name="VARIABLETYPE", type="string", length=20, nullable=false)
     */
    private $variabletype;

    /**
     * @var integer
     *
     * @ORM\Column(name="SEQNO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="PARAMETER_METHODS_SEQ", allocationSize=1, initialValue=1)
     */
    private $seqno;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Groups", mappedBy="pmdSeqno")
     */
    private $grpName;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ObservationValues", mappedBy="pmdSeqno")
     */
    private $observationValues;


    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\SpecimenValues", mappedBy="pmdSeqno")
     */
    private $specimenValues;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->grpName = new \Doctrine\Common\Collections\ArrayCollection();
        $this->observationValues = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set creDat
     *
     * @param \DateTime $creDat
     * @return ParameterMethods
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
     * @return ParameterMethods
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
     * @return ParameterMethods
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
     * @return ParameterMethods
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
     * @return ParameterMethods
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
     * @return ParameterMethods
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
     * Set origin
     *
     * @param string $origin
     * @return ParameterMethods
     */
    public function setOrigin($origin)
    {
        $this->origin = $origin;
    
        return $this;
    }

    /**
     * Get origin
     *
     * @return string 
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * Set unit
     *
     * @param string $unit
     * @return ParameterMethods
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
    
        return $this;
    }

    /**
     * Get unit
     *
     * @return string 
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set variabletype
     *
     * @param string $variabletype
     * @return ParameterMethods
     */
    public function setVariabletype($variabletype)
    {
        $this->variabletype = $variabletype;

        return $this;
    }

    /**
     * Get variabletype
     *
     * @return string
     */
    public function getVariabletype()
    {
        return $this->variabletype;
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
     * Add grpName
     *
     * @param \AppBundle\Entity\Groups $grpName
     * @return ParameterMethods
     */
    public function addGrpName(\AppBundle\Entity\Groups $grpName)
    {
        $this->grpName[] = $grpName;
    
        return $this;
    }

    /**
     * Remove grpName
     *
     * @param \AppBundle\Entity\Groups $grpName
     */
    public function removeGrpName(\AppBundle\Entity\Groups $grpName)
    {
        $this->grpName->removeElement($grpName);
    }

    /**
     * Get grpName
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGrpName()
    {
        return $this->grpName;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getObservationValues()
    {
        return $this->observationValues;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $observationValues
     * @return ParameterMethods
     */
    public function setObservationValues($observationValues)
    {
        $this->observationValues = $observationValues;
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSpecimenValues()
    {
        return $this->specimenValues;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $specimenValues
     * @return ParameterMethods
     */
    public function setSpecimenValues($specimenValues)
    {
        $this->specimenValues = $specimenValues;
        return $this;
    }

    public function isCodParameter(){
        $a=strpos($this->getName(),'Cause of death');
        return $a !==  false && $a>=0;
    }



}
