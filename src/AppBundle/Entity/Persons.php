<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Persons
 *
 * @ORM\Table(name="PERSONS", uniqueConstraints={@ORM\UniqueConstraint(name="psn_email_uk", columns={"EMAIL"}), @ORM\UniqueConstraint(name="psn_uk", columns={"FIRST_NAME", "LAST_NAME"})}, indexes={@ORM\Index(name="psn_ite_fk_i", columns={"ITE_SEQNO"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\PersonsRepository")
 */
class Persons
{
    /**
     * @var string
     *
     * @ORM\Column(name="ADDRESS", type="string", length=250, nullable=true)
     */
    private $address;

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
     * @ORM\Column(name="EMAIL", type="string", length=80, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="FIRST_NAME", type="string", length=15, nullable=true)
     */
    private $firstName;

    /**
     * @var integer
     *
     * @ORM\Column(name="IDOD_ID", type="integer", nullable=true)
     */
    private $idodId;

    /**
     * @var string
     *
     * @ORM\Column(name="LAST_NAME", type="string", length=25, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="LOGIN_NAME", type="string", length=25, nullable=true)
     */
    private $loginName;

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
     * @ORM\Column(name="PASSWORD", type="string", length=60, nullable=true)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="PHONE_NUMBER", type="string", length=20, nullable=true)
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="PIC", type="string", length=100, nullable=true)
     */
    private $pic;

    /**
     * @var string
     *
     * @ORM\Column(name="SESSIONID", type="string", length=32, nullable=true)
     */
    private $sessionid;

    /**
     * @var string
     *
     * @ORM\Column(name="SEX", type="string", length=3, nullable=true)
     */
    private $sex;

    /**
     * @var string
     *
     * @ORM\Column(name="TITLE", type="string", length=15, nullable=true)
     */
    private $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="SEQNO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="PERSONS_SEQ", allocationSize=1, initialValue=1)
     */
    private $seqno;

    /**
     * @var \AppBundle\Entity\Institutes
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Institutes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ITE_SEQNO", referencedColumnName="SEQNO")
     * })
     */
    private $iteSeqno;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Groups", mappedBy="psnSeqno")
     */
    private $grpName;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Event2Persons", mappedBy="psnSeqno")
     */
    private $event2Persons;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Person2Requests", mappedBy="psnSeqno")
     */
    private $person2Requests;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->person2Requests = new \Doctrine\Common\Collections\ArrayCollection();
        $this->grpName = new \Doctrine\Common\Collections\ArrayCollection();
        $this->event2Persons = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set address
     *
     * @param string $address
     * @return Persons
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set creDat
     *
     * @param \DateTime $creDat
     * @return Persons
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
     * @return Persons
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
     * Set email
     *
     * @param string $email
     * @return Persons
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Persons
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set idodId
     *
     * @param integer $idodId
     * @return Persons
     */
    public function setIdodId($idodId)
    {
        $this->idodId = $idodId;
    
        return $this;
    }

    /**
     * Get idodId
     *
     * @return integer 
     */
    public function getIdodId()
    {
        return $this->idodId;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Persons
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    
        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set loginName
     *
     * @param string $loginName
     * @return Persons
     */
    public function setLoginName($loginName)
    {
        $this->loginName = $loginName;
    
        return $this;
    }

    /**
     * Get loginName
     *
     * @return string 
     */
    public function getLoginName()
    {
        return $this->loginName;
    }

    /**
     * Set modDat
     *
     * @param \DateTime $modDat
     * @return Persons
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
     * @return Persons
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
     * Set password
     *
     * @param string $password
     * @return Persons
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     * @return Persons
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    
        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string 
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set pic
     *
     * @param string $pic
     * @return Persons
     */
    public function setPic($pic)
    {
        $this->pic = $pic;
    
        return $this;
    }

    /**
     * Get pic
     *
     * @return string 
     */
    public function getPic()
    {
        return $this->pic;
    }

    /**
     * Set sessionid
     *
     * @param string $sessionid
     * @return Persons
     */
    public function setSessionid($sessionid)
    {
        $this->sessionid = $sessionid;
    
        return $this;
    }

    /**
     * Get sessionid
     *
     * @return string 
     */
    public function getSessionid()
    {
        return $this->sessionid;
    }

    /**
     * Set sex
     *
     * @param string $sex
     * @return Persons
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
    
        return $this;
    }

    /**
     * Get sex
     *
     * @return string 
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Persons
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
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
     * Set iteSeqno
     *
     * @param \AppBundle\Entity\Institutes $iteSeqno
     * @return Persons
     */
    public function setIteSeqno(\AppBundle\Entity\Institutes $iteSeqno = null)
    {
        $this->iteSeqno = $iteSeqno;
    
        return $this;
    }

    /**
     * Get iteSeqno
     *
     * @return \AppBundle\Entity\Institutes 
     */
    public function getIteSeqno()
    {
        return $this->iteSeqno;
    }

    /**
     * Add grpName
     *
     * @param \AppBundle\Entity\Groups $grpName
     * @return Persons
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
    public function getEvent2Persons()
    {
        return $this->event2Persons;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $event2Persons
     * @return Persons
     */
    public function setEvent2Persons($event2Persons)
    {
        $this->event2Persons = $event2Persons;
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPerson2Requests()
    {
        return $this->person2Requests;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $person2Requests
     * @return Persons
     */
    public function setPerson2Requests($person2Requests)
    {
        $this->person2Requests = $person2Requests;
        return $this;
    }



    /**
     * Get fullyQualifiedName
     *
     * @return string
     */
    public function getFullyQualifiedName()
    {
        return $this->getFirstName().' '.$this->getLastName();
    }
}
