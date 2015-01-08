<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stations
 *
 * @ORM\Table(name="STATIONS", indexes={@ORM\Index(name="IDX_61C4E9A5EE3C1733", columns={"PCE_SEQNO"})})
 * @ORM\Entity
 */
class Stations
{
    /**
     * @var string
     *
     * @ORM\Column(name="AREA_TYPE", type="string", length=100, nullable=true)
     */
    private $areaType;

    /**
     * @var string
     *
     * @ORM\Column(name="CODE", type="string", length=50, nullable=true)
     */
    private $code;

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
     * @ORM\Column(name="DESCRIPTION", type="string", length=4000, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="LATITUDE", type="string", length=20, nullable=true)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="LAT_DEG", type="decimal", precision=25, scale=12, nullable=true)
     */
    private $latDeg;

    /**
     * @var string
     *
     * @ORM\Column(name="LONGITUDE", type="string", length=20, nullable=true)
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
     * @var integer
     *
     * @ORM\Column(name="SEQNO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="STATIONS_SEQNO_seq", allocationSize=1, initialValue=1)
     */
    private $seqno;

    /**
     * @var \AppBundle\Entity\Places
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Places")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="PCE_SEQNO", referencedColumnName="SEQNO")
     * })
     */
    private $pceSeqno;


}
