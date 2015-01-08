<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Necropsies
 *
 * @ORM\Table(name="NECROPSIES")
 * @ORM\Entity
 */
class Necropsies
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
     * @ORM\Column(name="PROGRAM", type="string", length=50, nullable=true)
     */
    private $program;

    /**
     * @var string
     *
     * @ORM\Column(name="REF_AUT", type="string", length=30, nullable=true)
     */
    private $refAut;

    /**
     * @var string
     *
     * @ORM\Column(name="REF_LABO", type="string", length=30, nullable=true)
     */
    private $refLabo;

    /**
     * @var \AppBundle\Entity\EventStates
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\EventStates")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ESE_SEQNO", referencedColumnName="SEQNO")
     * })
     */
    private $eseSeqno;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\LesionTypes", mappedBy="ncyEseSeqno")
     */
    private $lteOgnCode;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lteOgnCode = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set creDat
     *
     * @param \DateTime $creDat
     * @return Necropsies
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
     * @return Necropsies
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
     * @return Necropsies
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
     * @return Necropsies
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
     * Set program
     *
     * @param string $program
     * @return Necropsies
     */
    public function setProgram($program)
    {
        $this->program = $program;
    
        return $this;
    }

    /**
     * Get program
     *
     * @return string 
     */
    public function getProgram()
    {
        return $this->program;
    }

    /**
     * Set refAut
     *
     * @param string $refAut
     * @return Necropsies
     */
    public function setRefAut($refAut)
    {
        $this->refAut = $refAut;
    
        return $this;
    }

    /**
     * Get refAut
     *
     * @return string 
     */
    public function getRefAut()
    {
        return $this->refAut;
    }

    /**
     * Set refLabo
     *
     * @param string $refLabo
     * @return Necropsies
     */
    public function setRefLabo($refLabo)
    {
        $this->refLabo = $refLabo;
    
        return $this;
    }

    /**
     * Get refLabo
     *
     * @return string 
     */
    public function getRefLabo()
    {
        return $this->refLabo;
    }

    /**
     * Set eseSeqno
     *
     * @param \AppBundle\Entity\EventStates $eseSeqno
     * @return Necropsies
     */
    public function setEseSeqno(\AppBundle\Entity\EventStates $eseSeqno)
    {
        $this->eseSeqno = $eseSeqno;
    
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
     * Add lteOgnCode
     *
     * @param \AppBundle\Entity\LesionTypes $lteOgnCode
     * @return Necropsies
     */
    public function addLteOgnCode(\AppBundle\Entity\LesionTypes $lteOgnCode)
    {
        $this->lteOgnCode[] = $lteOgnCode;
    
        return $this;
    }

    /**
     * Remove lteOgnCode
     *
     * @param \AppBundle\Entity\LesionTypes $lteOgnCode
     */
    public function removeLteOgnCode(\AppBundle\Entity\LesionTypes $lteOgnCode)
    {
        $this->lteOgnCode->removeElement($lteOgnCode);
    }

    /**
     * Get lteOgnCode
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLteOgnCode()
    {
        return $this->lteOgnCode;
    }
}