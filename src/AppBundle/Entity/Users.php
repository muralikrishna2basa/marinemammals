<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * Users
 *
 * @ORM\Table(name="USERS")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\UsersRepository")
 */
class Users implements AdvancedUserInterface, \Serializable
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
     * @var integer
     *
     * @ORM\Column(name="SEQNO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="USERS_SEQ", allocationSize=1, initialValue=1)
     */
    private $seqno;

    /**
     * @var \AppBundle\Entity\Persons
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Persons", inversedBy="user")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="PSN_SEQNO", referencedColumnName="SEQNO", nullable=false)
     * })
     */
    private $person;

    /**
     * @var string
     *
     * @ORM\Column(name="USERNAME", type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="PASSWORD", type="string", length=64)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="EMAIL", type="string", length=60, unique=true)
     */
    private $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ISACTIVE", type="boolean")
     */
    private $isActive;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Roles", inversedBy="users")
     * @ORM\JoinTable(name="USER2ROLE", inverseJoinColumns={@ORM\JoinColumn(name="RLE_SEQNO", referencedColumnName="SEQNO")},
     *     joinColumns={@ORM\JoinColumn(name="USR_SEQNO", referencedColumnName="SEQNO")})
     */
    private $roles;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->isActive = true;
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqseqno(null, true));
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return Users
     */
    public function setUsername($username)
    {
        $this->username=$username;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return Users
     */
    public function setPassword($password)
    {
        $this->password=$password;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return $this->roles->toArray();
    }

    /**
     * @param ArrayCollection $roles
     * @return Users
     */
    public function setRoles(ArrayCollection $roles)
    {
        $this->roles=$roles;
        return  $this;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->getSeqno();
    }

    /**
     * @return integer
     */
    public function getSeqno()
    {
        return $this->seqno;
    }

    /**
     * @param integer $seqno
     * @return Users
     */
    public function setSeqno($seqno)
    {
        $this->seqno = $seqno;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Users
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param boolean $isActive
     * @return Users
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @return Persons
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * @param Persons $person
     * @return Users
     */
    public function setPerson($person)
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreDat()
    {
        return $this->creDat;
    }

    /**
     * @param \DateTime $creDat
     * @return Users
     */
    public function setCreDat($creDat)
    {
        $this->creDat = $creDat;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreUser()
    {
        return $this->creUser;
    }

    /**
     * @param string $creUser
     * @return Users
     */
    public function setCreUser($creUser)
    {
        $this->creUser = $creUser;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getModDat()
    {
        return $this->modDat;
    }

    /**
     * @param \DateTime $modDat
     * @return Users
     */
    public function setModDat($modDat)
    {
        $this->modDat = $modDat;
        return $this;
    }

    /**
     * @return string
     */
    public function getModUser()
    {
        return $this->modUser;
    }

    /**
     * @param string $modUser
     * @return Users
     */
    public function setModUser($modUser)
    {
        $this->modUser = $modUser;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * Checks whether the user's account has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw an AccountExpiredException and prevent login.
     *
     * @return bool true if the user's account is non expired, false otherwise
     *
     * @see AccountExpiredException
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is locked.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a LockedException and prevent login.
     *
     * @return bool true if the user is not locked, false otherwise
     *
     * @see LockedException
     */
    public function isAccountNonLocked()
    {
        return true;
    }

    /**
     * Checks whether the user's credentials (password) has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a CredentialsExpiredException and prevent login.
     *
     * @return bool true if the user's credentials are non expired, false otherwise
     *
     * @see CredentialsExpiredException
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is enabled.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a DisabledException and prevent login.
     *
     * @return bool true if the user is enabled, false otherwise
     *
     * @see DisabledException
     */
    public function isEnabled()
    {
        return true;
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->seqno,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->seqno,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }
}