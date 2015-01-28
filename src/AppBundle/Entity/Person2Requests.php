<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Person2Requests
 *
 * @ORM\Table(name="PERSON2REQUESTS", indexes={@ORM\Index(name="P2R_PK", columns={"RLN_SEQNO", "PSN_SEQNO"}), @ORM\Index(name="P2R_PSN_FK_I", columns={"PSN_SEQNO"})})
 * @ORM\Entity
 */
class Person2Requests
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
     * @ORM\Column(name="P2R_TYPE", type="string", length=4)
     */
    private $p2rType;

    /**
     * @var \AppBundle\Entity\Persons
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Persons", inversedBy="seqno")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="PSN_SEQNO", referencedColumnName="SEQNO")
     * })
     */
    private $psnSeqno;

    /**
     * @var \AppBundle\Entity\RequestLoans
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\RequestLoans", inversedBy="seqno")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="RLN_SEQNO", referencedColumnName="SEQNO")
     * })
     */
    private $rlnSeqno;


    /**
     * Set creDat
     *
     * @param \DateTime $creDat
     * @return Person2Requests
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
     * @return Person2Requests
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
     * @return Person2Requests
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
     * @return Person2Requests
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
     * Set p2rType
     *
     * @param string $p2rType
     * @return Person2Requests
     */
    public function setP2rType($p2rType)
    {
        $this->p2rType = $p2rType;
    
        return $this;
    }

    /**
     * Get p2rType
     *
     * @return string 
     */
    public function getP2rType()
    {
        return $this->p2rType;
    }

    /**
     * Set psnSeqno
     *
     * @param \AppBundle\Entity\Persons $psnSeqno
     * @return Person2Requests
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
     * Get rlnSeqno
     * @return \AppBundle\Entity\RequestLoans
     */
    public function getRlnSeqno()
    {
        return $this->rlnSeqno;
    }

    /**
     * @param RequestLoans $rlnSeqno
     * @return Person2Requests
     */
    public function setRlnSeqno($rlnSeqno)
    {
        $this->rlnSeqno = $rlnSeqno;
        return $this;
    }



}
