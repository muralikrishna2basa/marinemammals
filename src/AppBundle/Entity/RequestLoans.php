<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RequestLoans
 *
 * @ORM\Table(name="REQUEST_LOANS")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\RequestLoansRepository")
 */
class RequestLoans
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
     * @ORM\Column(name="DATE_OUT", type="datetime", nullable=true)
     */
    private $dateOut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_REQUEST", type="datetime", nullable=false)
     */
    private $dateRequest;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_RT", type="datetime", nullable=true)
     */
    private $dateRt;

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
     * @ORM\Column(name="STATUS", type="string", length=50, nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="STUDY_DESCRIPTION", type="string", length=250, nullable=false)
     */
    private $studyDescription;

    /**
     * @var integer
     *
     * @ORM\Column(name="SEQNO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="REQUEST_LOANS_SEQ", allocationSize=1, initialValue=1)
     */
    private $seqno;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Samples", mappedBy="rlnSeqno")
     */
    private $speSeqno;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\User2Requests", mappedBy="rlnSeqno")
     */
    private $user2Requests;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->speSeqno = new \Doctrine\Common\Collections\ArrayCollection();
        $this->user2Requests = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set creDat
     *
     * @param \DateTime $creDat
     * @return RequestLoans
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
     * @return RequestLoans
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
     * Set dateOut
     *
     * @param \DateTime $dateOut
     * @return RequestLoans
     */
    public function setDateOut($dateOut)
    {
        $this->dateOut = $dateOut;
    
        return $this;
    }

    /**
     * Get dateOut
     *
     * @return \DateTime 
     */
    public function getDateOut()
    {
        return $this->dateOut;
    }

    /**
     * Set dateRequest
     *
     * @param \DateTime $dateRequest
     * @return RequestLoans
     */
    public function setDateRequest($dateRequest)
    {
        $this->dateRequest = $dateRequest;
    
        return $this;
    }

    /**
     * Get dateRequest
     *
     * @return \DateTime 
     */
    public function getDateRequest()
    {
        return $this->dateRequest;
    }

    /**
     * Set dateRt
     *
     * @param \DateTime $dateRt
     * @return RequestLoans
     */
    public function setDateRt($dateRt)
    {
        $this->dateRt = $dateRt;
    
        return $this;
    }

    /**
     * Get dateRt
     *
     * @return \DateTime 
     */
    public function getDateRt()
    {
        return $this->dateRt;
    }

    /**
     * Set modDat
     *
     * @param \DateTime $modDat
     * @return RequestLoans
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
     * @return RequestLoans
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
     * Set status
     *
     * @param integer $status
     * @return RequestLoans
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set studyDescription
     *
     * @param string $studyDescription
     * @return RequestLoans
     */
    public function setStudyDescription($studyDescription)
    {
        $this->studyDescription = $studyDescription;
    
        return $this;
    }

    /**
     * Get studyDescription
     *
     * @return string 
     */
    public function getStudyDescription()
    {
        return $this->studyDescription;
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
     * Add speSeqno
     *
     * @param \AppBundle\Entity\Samples $speSeqno
     * @return RequestLoans
     */
    public function addSpeSeqno(\AppBundle\Entity\Samples $speSeqno)
    {
        $this->speSeqno[] = $speSeqno;
        return $this;
    }

    /**
     * Add speSeqno
     *
     * @param array $speSeqno
     * @return RequestLoans
     */
    public function addSpeSeqnoArray($speSeqno)
    {
        $this->speSeqno[] = $speSeqno;
        return $this;
    }

    /**
     * Remove speSeqno
     *
     * @param \AppBundle\Entity\Samples $speSeqno
     */
    public function removeSpeSeqno(\AppBundle\Entity\Samples $speSeqno)
    {
        $this->speSeqno->removeElement($speSeqno);
    }

    /**
     * Get speSeqno
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSpeSeqno()
    {
        return $this->speSeqno;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUser2Requests()
    {
        return $this->user2Requests;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $user2Requests
     * @return RequestLoans
     */
    public function setUser2Requests($user2Requests)
    {
        $this->user2Requests = $user2Requests;
        return $this;
    }

    /**
     * @param \AppBundle\Entity\User2Requests $user2Request
     * @return RequestLoans
     */
    public function addUser2Requests($user2Request)
    {
        $this->user2Requests->add($user2Request);
        return $this;
    }

    public function nbSamples(){
        return $this->getSpeSeqno()->count();
    }
}
