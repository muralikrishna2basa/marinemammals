<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Samples
 *
 * @ORM\Table(name="SAMPLES", indexes={@ORM\Index(name="spe_cln_fk_i", columns={"CLN_SEQNO"})})
 * @ORM\Entity
 */
class Samples
{
    /**
     * @var string
     *
     * @ORM\Column(name="ANALYZE_DEST", type="string", length=3, nullable=false)
     */
    private $analyzeDest;

    /**
     * @var string
     *
     * @ORM\Column(name="AVAILABILITY", type="string", length=20, nullable=true)
     */
    private $availability;

    /**
     * @var string
     *
     * @ORM\Column(name="CONSERVATION_MODE", type="string", length=10, nullable=false)
     */
    private $conservationMode;

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
     * @ORM\Column(name="SPE_TYPE", type="string", length=3, nullable=false)
     */
    private $speType;

    /**
     * @var string
     *
     * @ORM\Column(name="SUBREF", type="string", length=10, nullable=true)
     */
    private $subref;

    /**
     * @var integer
     *
     * @ORM\Column(name="SEQNO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="SAMPLES_SEQNO_seq", allocationSize=1, initialValue=1)
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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\OrganLesions", mappedBy="speSeqno")
     */
    private $olnNcyEseSeqno;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\RequestLoans", mappedBy="speSeqno")
     */
    private $rlnSeqno;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->olnNcyEseSeqno = new \Doctrine\Common\Collections\ArrayCollection();
        $this->rlnSeqno = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
