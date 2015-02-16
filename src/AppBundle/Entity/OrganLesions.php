<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrganLesions
 *
 * @ORM\Table(name="ORGAN_LESIONS", indexes={@ORM\Index(name="OLN_PK2", columns={"NCY_ESE_SEQNO","LTE_SEQNO"})})
 * @ORM\Entity
 */
class OrganLesions implements ValueAssignable
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
     * @ORM\Column(name="DESCRIPTION", type="string", length=1000, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="SCALE", type="string", length=50, nullable=true)
     */
    private $scale;

    /**
     * @var \AppBundle\Entity\LesionTypes
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="ASSIGNED")
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\LesionTypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="LTE_SEQNO", referencedColumnName="SEQNO", nullable=false)
     * })
     */
    private $lteSeqno;

    /**
     * @var \AppBundle\Entity\Necropsies
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Necropsies")
     * @ORM\JoinColumns({@ORM\JoinColumn(name="NCY_ESE_SEQNO", referencedColumnName="ESE_SEQNO", nullable=false)})
     */
    private $ncyEseSeqno;


    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\LesionValues", mappedBy="olnNcyEseSeqno")
     */
    private $lesionValues;


    /**
     * Set creDat
     *
     * @param \DateTime $creDat
     * @return OrganLesions
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
     * @return OrganLesions
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
     * @return OrganLesions
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
     * @return OrganLesions
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

    //------------------
    /**
     * @return LesionTypes
     */
    public function getLteSeqno()
    {
        return $this->lteSeqno;
    }

    /**
     * @param LesionTypes $lteSeqno
     * @return OrganLesions
     */
    public function setLteSeqno($lteSeqno)
    {
        $this->lteSeqno = $lteSeqno;
        return $this;
    }

    /**
     * @return Necropsies
     */
    public function getNcyEseSeqno()
    {
        return $this->ncyEseSeqno;
    }

    /**
     * @param Necropsies $ncyEseSeqno
     * @return OrganLesions
     */
    public function setNcyEseSeqno($ncyEseSeqno)
    {
        $this->ncyEseSeqno = $ncyEseSeqno;
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getValues()
    {
        return $this->lesionValues;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $lesionValues
     * @return OrganLesions
     */
    public function setValues(\Doctrine\Common\Collections\Collection $lesionValues)
    {
        $this->lesionValues = $lesionValues;
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

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return OrganLesions
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getScale()
    {
        return $this->scale;
    }

    /**
     * @param string $scale
     * @return OrganLesions
     */
    public function setScale($scale)
    {
        $this->scale = $scale;
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLesionValues()
    {
        return $this->lesionValues;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $lesionValues
     * @return OrganLesions
     */
    public function setLesionValues($lesionValues)
    {
        $this->lesionValues = $lesionValues;
        return $this;
    }
    
    
}

