<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event2persons
 *
 * @ORM\Table(name="EVENT2PERSONS", indexes={@ORM\Index(name="IDX_B3DFBBA574D02126", columns={"ESE_SEQNO"}), @ORM\Index(name="IDX_B3DFBBA5908072E2", columns={"PSN_SEQNO"})})
 * @ORM\Entity
 */
class Event2persons
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
     * @ORM\Column(name="E2P_TYPE", type="string", length=2)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $e2pType;

    /**
     * @var \AppBundle\Entity\Persons
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Persons")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="PSN_SEQNO", referencedColumnName="SEQNO")
     * })
     */
    private $psnSeqno;

    /**
     * @var \AppBundle\Entity\EventStates
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\EventStates")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ESE_SEQNO", referencedColumnName="SEQNO")
     * })
     */
    private $eseSeqno;



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

    /**
     * Set e2pType
     *
     * @param string $e2pType
     * @return Event2persons
     */
    public function setE2pType($e2pType)
    {
        $this->e2pType = $e2pType;
    
        return $this;
    }

    /**
     * Get e2pType
     *
     * @return string 
     */
    public function getE2pType()
    {
        return $this->e2pType;
    }

    /**
     * Set psnSeqno
     *
     * @param \AppBundle\Entity\Persons $psnSeqno
     * @return Event2persons
     */
    public function setPsnSeqno(\AppBundle\Entity\Persons $psnSeqno)
    {
        $this->psnSeqno = $psnSeqno;
    
        return $this;
    }

    /**
     * Get psnSeqno
     *
     * @return \AppBundle\Entity\Persons 
     */
    public function getPsnSeqno()
    {
        return $this->psnSeqno;
    }

    /**
     * Set eseSeqno
     *
     * @param \AppBundle\Entity\EventStates $eseSeqno
     * @return Event2persons
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
}
