<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User2Requests
 *
 * @ORM\Table(name="USER2REQUESTS", indexes={@ORM\Index(name="U2R_PK", columns={"RLN_SEQNO", "USR_SEQNO"})})
 * @ORM\Entity
 */
class User2Requests
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
     * @ORM\Column(name="P2R_TYPE", type="string", length=50, nullable=true)
     */
    private $p2rType;

    /**
     * @var \AppBundle\Entity\Users
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Users", inversedBy="user2Requests")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="USR_SEQNO", referencedColumnName="SEQNO", nullable=false)
     * })
     */
    private $usrSeqno;

    /**
     * @var \AppBundle\Entity\RequestLoans
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\RequestLoans", inversedBy="user2Requests")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="RLN_SEQNO", referencedColumnName="SEQNO", nullable=false)
     * })
     */
    private $rlnSeqno;


    /**
     * Set creDat
     *
     * @param \DateTime $creDat
     * @return User2Requests
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
     * @return User2Requests
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
     * @return User2Requests
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
     * @return User2Requests
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
     * @return User2Requests
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
     * Set usrSeqno
     *
     * @param \AppBundle\Entity\Users $usrSeqno
     * @return User2Requests
     */
    public function setUsrSeqno(\AppBundle\Entity\Users $usrSeqno)
    {
        $this->usrSeqno = $usrSeqno;
    
        return $this;
    }

    /**
     * Get usrSeqno
     *
     * @return \AppBundle\Entity\Users 
     */
    public function getUsrSeqno()
    {
        return $this->usrSeqno;
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
     * @return User2Requests
     */
    public function setRlnSeqno($rlnSeqno)
    {
        $this->rlnSeqno = $rlnSeqno;
        return $this;
    }



}
