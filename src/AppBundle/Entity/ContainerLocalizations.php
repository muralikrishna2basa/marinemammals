<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContainerLocalizations
 *
 * @ORM\Table(name="CONTAINER_LOCALIZATIONS", uniqueConstraints={@ORM\UniqueConstraint(name="cln_uk", columns={"CLN_SEQNO", "NAME", "CONTAINER_TYPE"})}, indexes={@ORM\Index(name="IDX_B611859EA0562FD1", columns={"CLN_SEQNO"})})
 * @ORM\Entity
 */
class ContainerLocalizations
{
    /**
     * @var string
     *
     * @ORM\Column(name="CONTAINER_TYPE", type="string", length=50, nullable=true)
     */
    private $containerType;

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
     * @ORM\Column(name="NAME", type="string", length=20, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="SEQNO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="CONTAINER_LOCALIZATIONS_SEQNO_", allocationSize=1, initialValue=1)
     */
    private $seqno;

    /**
     * @var \AppBundle\Entity\ContainerLocalizations
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ContainerLocalizations")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CLN_SEQNO", referencedColumnName="SEQNO")
     * })
     */
    private $clnSeqno;



    /**
     * Set containerType
     *
     * @param string $containerType
     * @return ContainerLocalizations
     */
    public function setContainerType($containerType)
    {
        $this->containerType = $containerType;
    
        return $this;
    }

    /**
     * Get containerType
     *
     * @return string 
     */
    public function getContainerType()
    {
        return $this->containerType;
    }

    /**
     * Set creDat
     *
     * @param \DateTime $creDat
     * @return ContainerLocalizations
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
     * @return ContainerLocalizations
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
     * @return ContainerLocalizations
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
     * @return ContainerLocalizations
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
     * Set name
     *
     * @param string $name
     * @return ContainerLocalizations
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
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
     * Get seqno
     *
     * @return integer 
     */
    public function getSeqno()
    {
        return $this->seqno;
    }

    /**
     * Set clnSeqno
     *
     * @param \AppBundle\Entity\ContainerLocalizations $clnSeqno
     * @return ContainerLocalizations
     */
    public function setClnSeqno(\AppBundle\Entity\ContainerLocalizations $clnSeqno = null)
    {
        $this->clnSeqno = $clnSeqno;
    
        return $this;
    }

    /**
     * Get clnSeqno
     *
     * @return \AppBundle\Entity\ContainerLocalizations 
     */
    public function getClnSeqno()
    {
        return $this->clnSeqno;
    }
}
