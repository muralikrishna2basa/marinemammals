<?php

namespace AppBundle\Entity;

use Symfony\Component\Security\Core\Role\RoleInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Roles
 *
 * @ORM\Table(name="ROLES")
 * @ORM\Entity()
 */
class Roles implements RoleInterface
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
     * @ORM\SequenceGenerator(sequenceName="ROLES_SEQ", allocationSize=1, initialValue=1)
     */
    private $seqno;

    /**
     * @var string
     *
     * @ORM\Column(name="NAME", type="string", length=30)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="ROLE", type="string", length=20, unique=true)
     */
    private $role;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="USERS", mappedBy="roles")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @see RoleInterface
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param string $role
     * @return Roles
     */
    public function setRole($role)
    {
        $this->role=$role;
        return $this;
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
     * @return Roles
     */
    public function setSeqno($seqno)
    {
        $this->seqno = $seqno;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Roles
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param ArrayCollection $users
     * @return Roles
     */
    public function setUsers($users)
    {
        $this->users = $users;
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
     * @return Roles
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
     * @return Roles
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
     * @return Roles
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
     * @return Roles
     */
    public function setModUser($modUser)
    {
        $this->modUser = $modUser;
        return $this;
    }
}