<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrganLesions
 *
 * @ORM\Table(name="ORGAN_LESIONS", indexes={@ORM\Index(name="OLN_PK", columns={"NCY_ESE_SEQNO","LTE_OGN_CODE","LTE_SEQNO"}), @ORM\Index(name="OLN_LTE_FK_I", columns={"LTE_OGN_CODE","LTE_SEQNO"})})
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
     * @var \AppBundle\Entity\LesionTypes
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\LesionTypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="LTE_SEQNO", referencedColumnName="SEQNO")
     *   @ORM\JoinColumn(name="LTE_OGN_CODE", referencedColumnName="OGN_CODE")
     * })
     */
    private $lteSeqno;

    /**
     * @var \AppBundle\Entity\Necropsies
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Necropsies")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="NCY_ESE_SEQNO", referencedColumnName="ESE_SEQNO")
     * })
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
     * @return Event2persons
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
     * @return Event2persons
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
     * @return Event2persons
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
     * @return Event2persons
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
     * @return Event2persons
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
     * @return Event2persons
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

    public function removeValue(EntityValues $ev)
    {
        $this->getValues()->removeElement($ev);
    }
}

