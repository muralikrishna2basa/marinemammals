<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Observations
 *
 * @ORM\Table(name="OBSERVATIONS", indexes={@ORM\Index(name="IDX_2EF312B895335730", columns={"PFM_SEQNO"}), @ORM\Index(name="IDX_2EF312B8A3C8473E", columns={"STN_SEQNO"})})
 * @ORM\Entity
 */
class Observations
{
    /**
     * @var boolean
     *
     * @ORM\Column(name="CONFIDENTIALITY", type="boolean", nullable=true)
     */
    private $confidentiality;

    /**
     * @var string
     *
     * @ORM\Column(name="CPN_CODE", type="string", length=10, nullable=true)
     */
    private $cpnCode;

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
     * @var integer
     *
     * @ORM\Column(name="ID_ACCESS_TMP", type="integer", nullable=true)
     */
    private $idAccessTmp;

    /**
     * @var string
     *
     * @ORM\Column(name="LATITUDE", type="string", length=50, nullable=true)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="LAT_DEG", type="decimal", precision=25, scale=15, nullable=true)
     */
    private $latDeg;

    /**
     * @var string
     *
     * @ORM\Column(name="LONGITUDE", type="string", length=50, nullable=true)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="LON_DEG", type="decimal", precision=25, scale=15, nullable=true)
     */
    private $lonDeg;

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
     * @ORM\Column(name="OSN_TYPE", type="string", length=10, nullable=false)
     */
    private $osnType;

    /**
     * @var integer
     *
     * @ORM\Column(name="PRECISION_FLAG", type="integer", nullable=true)
     */
    private $precisionFlag;

    /**
     * @var integer
     *
     * @ORM\Column(name="SAMPLINGEFFORT", type="integer", nullable=true)
     */
    private $samplingeffort;

    /**
     * @var string
     *
     * @ORM\Column(name="WEBCOMMENTS_EN", type="string", length=250, nullable=true)
     */
    private $webcommentsEn;

    /**
     * @var string
     *
     * @ORM\Column(name="WEBCOMMENTS_FR", type="string", length=250, nullable=true)
     */
    private $webcommentsFr;

    /**
     * @var string
     *
     * @ORM\Column(name="WEBCOMMENTS_NL", type="string", length=250, nullable=true)
     */
    private $webcommentsNl;

    /**
     * @var \AppBundle\Entity\EventStates
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\EventStates")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ESE_SEQNO", referencedColumnName="SEQNO")
     * })
     */
    private $eseSeqno;

    /**
     * @var \AppBundle\Entity\Stations
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Stations")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="STN_SEQNO", referencedColumnName="SEQNO")
     * })
     */
    private $stnSeqno;

    /**
     * @var \AppBundle\Entity\Platforms
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Platforms")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="PFM_SEQNO", referencedColumnName="SEQNO")
     * })
     */
    private $pfmSeqno;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Sources", mappedBy="osnSeqno")
     */
    private $sreSeqno;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sreSeqno = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
