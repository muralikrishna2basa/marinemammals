<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Specimens
 *
 * @ORM\Table(name="SPECIMENS", indexes={@ORM\Index(name="idx_txn_seqno", columns={"TXN_SEQNO"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\SpecimensRepository")
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
     * @var boolean
     *
     * @ORM\Column(name="IDENTIFICATION_CERTAINTY", type="boolean", nullable=true)
     */
    private $identificationCertainty;

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
     * @ORM\Column(name="SEX", type="string", length=50, nullable=true)
     */
    private $sex;

    /**
     * @var integer
     *
     * @ORM\Column(name="SEQNO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="SPECIMENS_SEQ", allocationSize=1, initialValue=1)
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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Spec2Events", mappedBy="scnSeqno")
     **/
    private $spec2events;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->identificationCertainty = false;
        $this->spec2events = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set identificationCertainty
     *
     * @param boolean $identificationCertainty
     * @return Specimens
     */
    public function setIdentificationCertainty($identificationCertainty)
    {
        $this->identificationCertainty = $identificationCertainty;

        return $this;
    }

    /**
     * Get identificationCertainty
     *
     * @return boolean
     */
    public function getIdentificationCertainty()
    {
        return $this->identificationCertainty;
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
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSpec2Events()
    {
        return $this->spec2events;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $spec2events
     * @return Specimens
     */
    public function setSpec2Events($spec2events)
    {
        $this->spec2events = $spec2events;

        return $this;
    }

    /**
     * @param \AppBundle\Entity\Spec2Events $spec2event
     */
    public function addToSpec2Events($spec2event)
    {
        $this->getSpec2Events()->add($spec2event);
    }

    private function IsNullOrEmptyString($question)
    {
        return (!isset($question) || trim($question) === '');
    }

    public function getNecropsyTagNice()
    {
        if (!$this->IsNullOrEmptyString($this->getNecropsyTag())) {
            return 'mumm:' . $this->getNecropsyTag();
        } else {
            return null;
        }
    }

    public function getRbinsTagNice()
    {
        if (!$this->IsNullOrEmptyString($this->getRbinsTag())) {
            return 'rbins:' . $this->getRbinsTag();
        } else {
            return null;
        }
    }

    public function getTagString()
    {
        $mumm = $this->getNecropsyTagNice();
        $rbins = $this->getNecropsyTagNice();
        if ($mumm and $rbins) {
            return '(' . $mumm . '/' . $rbins . ')';
        } elseif ($mumm) {
            return '(' . $mumm . ')';
        } elseif ($rbins) {
            return '(' . $rbins . ')';
        } else return '';
    }

    public function getFullyQualifiedName()
    {
        return $this->getSeqno() . ' - ' . $this->getTxnSeqno()->getVernacularNameEn() . ' ' . $this->getTagString();
    }

    public function isScnNumberLegal()
    {
        foreach ($this->getSpec2Events() as $s2e) {
            if ($this->getScnNumber() > 1 and ($s2e->hasPertinentValues() or $this->getSex() !== null or $this->getRbinsTag() !== null or $this->getNecropsyTag() !== null)) {
                return false;
            }
        }
        return true;
    }

    public function isSexLegal()
    {
        if ($this->getScnNumber() === null && $this->getSex() === null) {
            return true;
        } elseif ($this->getScnNumber() > 1) {
            return $this->getSex() === null;
        } else return $this->getSex() !== null;
    }

    public function AliveNow(){
        return $this->isAliveAtMoment(new \DateTime());
    }
    /**
     * Get whether the specimen is alive or dead at the given time. Time is measured in days.
     * Returns:
     * -1: if the dead or alive status cannot be gathered for this time
     * 0: if the specimen is dead at this time
     * 1: if the specimen is alive at this time
     * 2: the specimen is alive according to latest info
     * @param \DateTime $m
     * @return integer
     *
     */
    public function isAliveAtMoment(\DateTime $m)
    {
        $ebefore = $this->getNearestEventAndSpec2EventsBefore($m);
        $eseBefore = $ebefore['EventStates'];
        $seBefore = $ebefore['Spec2Events'];
        $osnTypeBefore = '';
        $t1 = new \DateTime();
        $dcBefore = '';
        $diBefore = '';
        $diBeforeAlive = -1;
        $dcBeforeAlive = -1;

        if ($eseBefore !== null) {
            $oBefore = $eseBefore->getObservation();
            if ($oBefore !== null) {
                $osnTypeBefore = $oBefore->getOsnType();
            }
            $t1 = $eseBefore->getEventDatetime();
        }
        if ($seBefore !== null) {
            $svL=$seBefore->getValues();
            foreach ($seBefore->getValues() as $sv) {
                if ($sv->getPmdName() === 'Decomposition Code') {
                    $dcBefore = $sv->getValue();
                }
                if ($sv->getPmdName() === 'During intervention') {
                    $diBefore = $sv->getValue();
                }
            }
        }

        if (in_array($diBefore, array('died during intervention/rehab same day', 'euthanized'))) {
            $diBeforeAlive = 0;
        } elseif (in_array($diBefore, array('released alive', 'taken to rehab'))) {
            $diBeforeAlive = 1;
        }
        if ($dcBefore == 1) {
            $dcBeforeAlive = 1;
        } elseif ($dcBefore > 1) {$dcBeforeAlive = 0;}
        switch ($osnTypeBefore) {
            case '':
                break;
            case 'FDH':
            case 'FDS':
            case 'FDB':
            case 'DTR':
                return 0;
            case 'B':
            case 'C':
            case 'CI':
                if ($dcBefore > 1) {
                    return 0;
                } else {
                    if ($t1 == $m) {
                        return 1;
                    } elseif ($t1 > $m) {
                        return $this->refineUnknownCod($m);
                    }
                }
            case 'FAB': //dc must be 1
                if ($t1 >= $m && $diBeforeAlive == 0) {
                    return 0;
                } elseif ($t1 == $m && $diBeforeAlive == 1) {
                    return 1;
                } elseif ($t1 > $m && $diBeforeAlive == 1) {
                    return $this->refineUnknownCod($m);
                } else {
                    return $this->refineUnknownCod($m);
                }
        }
    }

    private function refineUnknownCod($m)
    {
        /*$eafter = $this->getNearestEventAndSpec2EventsAfter($m);
        $eseAfter = $eafter['EventStates'];
        $seAfter = $eafter['Spec2Events'];
        $osnTypeAfter = '';
        $t1 = new \DateTime();
        $dcAfter = '';
        $diAfter = '';
        $diAfterAlive = -1;
        $dcAfterAlive = -1;

*/

        return -1;
    }

    /**
     * @param \DateTime $m
     * @return array
     *
     */
    private function getNearestEventAndSpec2EventsBefore(\DateTime $m)
    {
        foreach ($this->getSpec2Events() as $se) {
            $ese = $se->getEseSeqno();
            $eseDate = $ese->getEventDatetime();
            if ($eseDate <= $m) {
                $r = array();
                $r['EventStates'] = $ese;
                $r['Spec2Events'] = $se;
                return $r;
            }
        }
        return null;
    }

    /**
     * @param \DateTime $m
     * @return array
     *
     */
    private function getNearestEventAndSpec2EventsAfter(\DateTime $m)
    {
        $s2eL = $this->getSpec2Events();
        for ($i = $s2eL->count(); $i >= 0; $i--) {
            $s2e = $s2eL->get($i);
            $ese = $s2e->getEseSeqno();
            $eseDate = $ese->getEventDatetime();
            if ($eseDate <= $m) {
                $r = array();
                $r['EventStates'] = $ese;
                $r['Spec2Events'] = $s2e;
                return $r;
            }
        }
        return null;
    }
}
