<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Debug\Exception\FatalErrorException;

/**
 * Places
 *
 * @ORM\Table(name="PLACES", uniqueConstraints={@ORM\UniqueConstraint(name="pl_uk_name", columns={"NAME"})}, indexes={@ORM\Index(name="idx_pce_seqno", columns={"PCE_SEQNO"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\PlacesRepository")
 */
class Places
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
     * @ORM\Column(name="NAME", type="string", length=100, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="TYPE", type="string", length=50, nullable=true)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="SEQNO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="PLACES_SEQ", allocationSize=1, initialValue=1)
     */
    private $seqno;

    /**
     * @var \AppBundle\Entity\Places
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Places", inversedBy="places")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="PCE_SEQNO", referencedColumnName="SEQNO")
     * })
     */
    private $pceSeqno;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Places", mappedBy="pceSeqno")
     */
    private $places;

    /**
     * Set creDat
     *
     * @param \DateTime $creDat
     * @return Places
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
     * @return Places
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
     * @return Places
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
     * @return Places
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
     * @return Places
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
     * Set type
     *
     * @param string $type
     * @return Places
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
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
     * Set pceSeqno
     *
     * @param \AppBundle\Entity\Places $pceSeqno
     * @return Places
     */
    public function setPceSeqno(\AppBundle\Entity\Places $pceSeqno = null)
    {
        $this->pceSeqno = $pceSeqno;

        return $this;
    }

    /**
     * Get pceSeqno
     *
     * @return \AppBundle\Entity\Places
     */
    public function getPceSeqno()
    {
        return $this->pceSeqno;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlaces()
    {
        return $this->places;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection  $places
     *
     * @return \AppBundle\Entity\Places
     */
    public function setPlaces($places)
    {
        $this->places = $places;
        return $this;
    }


    /**
     * Get parentName
     *
     * @return string
     */
    public function getParentName()
    {
        if ($this->getPceSeqno() === null) {
            return 'ROOT';
        } else {
            return $this->getPceSeqno()->getName();
        }

    }

    /**
     * Get fully Qualified Name
     *
     * @return \AppBundle\Entity\Places
     */
    public function getFullyQualifiedName()
    {
        return $this->getParentName() . ' - ' . $this->getName() . ' (' . $this->getType() . ')';
    }

    public $iteration = 0;
    public $iterationstring = 'start';

    /**
     * Get Place name
     *
     * @return string
     */
    public function getPlaceName()
    {
        $name=$this->getName();
        $isCountry=($this->getType() === 'CTY');
        if($isCountry){
            return $name;
        }
        else{
            //return ucfirst(strtolower($name));
            return $name;
        }
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        $type = $this->getType();
        $name = $this->getName();
        if ($type === 'CTY') {
            $this->iterationstring = $this->iterationstring . '-- end: ' . $this->iteration;
            return $this->getName();
        }
        if ($name === 'WORLD') {
            return 'THE_VOID_BETWEEN_THE_STARS';
        }
        if ($type === 'CTY') {
            $this->iterationstring = $this->iterationstring . '-- end: ' . $this->iteration;
            return $this->getName();
        } elseif (in_array($type, array('LTY', 'RVR', 'OTR'))) {
            $this->iteration++;
            $this->iterationstring = $this->iterationstring . '--' . $this->getName();
            $parentPlace = $this->getPceSeqno();
            // \Doctrine\Common\Util\Debug::dump($name.'----'.get_class($parentPlace));
            if($parentPlace !== null){
                return $parentPlace->getCountry();
            }
        } else return null;
        /*elseif ($this->iteration=100){
            return '';
        }*/
    }

}
