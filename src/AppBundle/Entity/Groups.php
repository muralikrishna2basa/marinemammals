<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Groups
 *
 * @ORM\Table(name="GROUPS")
 * @ORM\Entity
 */
class Groups
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ACCESS_LEVEL", type="integer", nullable=false)
     */
    private $accessLevel;

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
     * @ORM\Column(name="DESCRIPTION", type="string", length=4000, nullable=false)
     */
    private $description;

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
     * @ORM\Column(name="NAME", type="string", length=30)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="GROUPS_NAME_seq", allocationSize=1, initialValue=1)
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\ParameterMethods", inversedBy="grpName")
     * @ORM\JoinTable(name="PARAMETER_GROUPS", inverseJoinColumns={@ORM\JoinColumn(name="PMD_SEQNO", referencedColumnName="SEQNO")},
     *     joinColumns={@ORM\JoinColumn(name="GRP_NAME", referencedColumnName="NAME")})
     */
    private $pmdSeqno;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Menus", mappedBy="grpName")
     */
    private $mnuSeqno;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Persons", mappedBy="grpName")
     * @ORM\JoinTable(name="PERSON2GROUPS", inverseJoinColumns={@ORM\JoinColumn(name="PSN_SEQNO", referencedColumnName="SEQNO")},
     *     joinColumns={@ORM\JoinColumn(name="GRP_NAME", referencedColumnName="NAME")})
     */
    private $psnSeqno;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pmdSeqno = new \Doctrine\Common\Collections\ArrayCollection();
        $this->mnuSeqno = new \Doctrine\Common\Collections\ArrayCollection();
        $this->psnSeqno = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set accessLevel
     *
     * @param integer $accessLevel
     * @return Groups
     */
    public function setAccessLevel($accessLevel)
    {
        $this->accessLevel = $accessLevel;

        return $this;
    }

    /**
     * Get accessLevel
     *
     * @return integer
     */
    public function getAccessLevel()
    {
        return $this->accessLevel;
    }

    /**
     * Set creDat
     *
     * @param \DateTime $creDat
     * @return Groups
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
     * @return Groups
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
     * Set description
     *
     * @param string $description
     * @return Groups
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set modDat
     *
     * @param \DateTime $modDat
     * @return Groups
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
     * @return Groups
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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add pmdSeqno
     *
     * @param \AppBundle\Entity\ParameterMethods $pmdSeqno
     * @return Groups
     */
    public function addPmdSeqno(\AppBundle\Entity\ParameterMethods $pmdSeqno)
    {
        $this->pmdSeqno[] = $pmdSeqno;

        return $this;
    }

    /**
     * Remove pmdSeqno
     *
     * @param \AppBundle\Entity\ParameterMethods $pmdSeqno
     */
    public function removePmdSeqno(\AppBundle\Entity\ParameterMethods $pmdSeqno)
    {
        $this->pmdSeqno->removeElement($pmdSeqno);
    }

    /**
     * Get pmdSeqno
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPmdSeqno()
    {
        return $this->pmdSeqno;
    }

    /**
     * Add mnuSeqno
     *
     * @param \AppBundle\Entity\Menus $mnuSeqno
     * @return Groups
     */
    public function addMnuSeqno(\AppBundle\Entity\Menus $mnuSeqno)
    {
        $this->mnuSeqno[] = $mnuSeqno;

        return $this;
    }

    /**
     * Remove mnuSeqno
     *
     * @param \AppBundle\Entity\Menus $mnuSeqno
     */
    public function removeMnuSeqno(\AppBundle\Entity\Menus $mnuSeqno)
    {
        $this->mnuSeqno->removeElement($mnuSeqno);
    }

    /**
     * Get mnuSeqno
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMnuSeqno()
    {
        return $this->mnuSeqno;
    }

    /**
     * Add psnSeqno
     *
     * @param \AppBundle\Entity\Persons $psnSeqno
     * @return Groups
     */
    public function addPsnSeqno(\AppBundle\Entity\Persons $psnSeqno)
    {
        $this->psnSeqno[] = $psnSeqno;

        return $this;
    }

    /**
     * Remove psnSeqno
     *
     * @param \AppBundle\Entity\Persons $psnSeqno
     */
    public function removePsnSeqno(\AppBundle\Entity\Persons $psnSeqno)
    {
        $this->psnSeqno->removeElement($psnSeqno);
    }

    /**
     * Get psnSeqno
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPsnSeqno()
    {
        return $this->psnSeqno;
    }
}
