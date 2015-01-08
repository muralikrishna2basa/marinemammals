<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Specimens
 *
 * @ORM\Table(name="SPECIMENS", indexes={@ORM\Index(name="IDX_B15B2FF190063FB8", columns={"TXN_SEQNO"})})
 * @ORM\Entity
 */
class Specimens
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
     * @ORM\Column(name="MUMMTAG", type="integer", nullable=true)
     */
    private $mummtag;

    /**
     * @var integer
     *
     * @ORM\Column(name="MUMMTAGSERIE", type="integer", nullable=true)
     */
    private $mummtagserie;

    /**
     * @var string
     *
     * @ORM\Column(name="NECROPSY_TAG", type="string", length=14, nullable=true)
     */
    private $necropsyTag;

    /**
     * @var string
     *
     * @ORM\Column(name="RBINS_TAG", type="string", length=20, nullable=true)
     */
    private $rbinsTag;

    /**
     * @var integer
     *
     * @ORM\Column(name="SCN_NUMBER", type="integer", nullable=false)
     */
    private $scnNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="SEX", type="string", length=3, nullable=true)
     */
    private $sex;

    /**
     * @var string
     *
     * @ORM\Column(name="SPECIE_FLAG", type="string", length=1, nullable=true)
     */
    private $specieFlag;

    /**
     * @var integer
     *
     * @ORM\Column(name="SEQNO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="SPECIMENS_SEQNO_seq", allocationSize=1, initialValue=1)
     */
    private $seqno;

    /**
     * @var \AppBundle\Entity\Taxa
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Taxa")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="TXN_SEQNO", referencedColumnName="SEQNO")
     * })
     */
    private $txnSeqno;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Spec2Events", mappedBy="scnSeqno")
     **/
    private $spec2event;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->eseSeqno = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set creDat
     *
     * @param \DateTime $creDat
     * @return Specimens
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
     * @return Specimens
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
     * @return Specimens
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
     * @return Specimens
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
     * Set mummtag
     *
     * @param integer $mummtag
     * @return Specimens
     */
    public function setMummtag($mummtag)
    {
        $this->mummtag = $mummtag;
    
        return $this;
    }

    /**
     * Get mummtag
     *
     * @return integer 
     */
    public function getMummtag()
    {
        return $this->mummtag;
    }

    /**
     * Set mummtagserie
     *
     * @param integer $mummtagserie
     * @return Specimens
     */
    public function setMummtagserie($mummtagserie)
    {
        $this->mummtagserie = $mummtagserie;
    
        return $this;
    }

    /**
     * Get mummtagserie
     *
     * @return integer 
     */
    public function getMummtagserie()
    {
        return $this->mummtagserie;
    }

    /**
     * Set necropsyTag
     *
     * @param string $necropsyTag
     * @return Specimens
     */
    public function setNecropsyTag($necropsyTag)
    {
        $this->necropsyTag = $necropsyTag;
    
        return $this;
    }

    /**
     * Get necropsyTag
     *
     * @return string 
     */
    public function getNecropsyTag()
    {
        return $this->necropsyTag;
    }

    /**
     * Set rbinsTag
     *
     * @param string $rbinsTag
     * @return Specimens
     */
    public function setRbinsTag($rbinsTag)
    {
        $this->rbinsTag = $rbinsTag;
    
        return $this;
    }

    /**
     * Get rbinsTag
     *
     * @return string 
     */
    public function getRbinsTag()
    {
        return $this->rbinsTag;
    }

    /**
     * Set scnNumber
     *
     * @param integer $scnNumber
     * @return Specimens
     */
    public function setScnNumber($scnNumber)
    {
        $this->scnNumber = $scnNumber;
    
        return $this;
    }

    /**
     * Get scnNumber
     *
     * @return integer 
     */
    public function getScnNumber()
    {
        return $this->scnNumber;
    }

    /**
     * Set sex
     *
     * @param string $sex
     * @return Specimens
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
     * Set specieFlag
     *
     * @param string $specieFlag
     * @return Specimens
     */
    public function setSpecieFlag($specieFlag)
    {
        $this->specieFlag = $specieFlag;
    
        return $this;
    }

    /**
     * Get specieFlag
     *
     * @return string 
     */
    public function getSpecieFlag()
    {
        return $this->specieFlag;
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
     * Set txnSeqno
     *
     * @param \AppBundle\Entity\Taxa $txnSeqno
     * @return Specimens
     */
    public function setTxnSeqno(\AppBundle\Entity\Taxa $txnSeqno = null)
    {
        $this->txnSeqno = $txnSeqno;
    
        return $this;
    }

    /**
     * Get txnSeqno
     *
     * @return \AppBundle\Entity\Taxa 
     */
    public function getTxnSeqno()
    {
        return $this->txnSeqno;
    }

    /**
     * Get spec2event
     *
     * @return \AppBundle\Entity\Spec2Events
     */
    public function getSpec2event()
    {
        return $this->spec2event;
    }
}
