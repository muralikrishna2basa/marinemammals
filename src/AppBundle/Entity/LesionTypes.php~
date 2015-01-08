<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LesionTypes
 *
 * @ORM\Table(name="LESION_TYPES", indexes={@ORM\Index(name="IDX_B8A6D97EFBE675E9", columns={"OGN_CODE"})})
 * @ORM\Entity
 */
class LesionTypes
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
     * @ORM\Column(name="NAME", type="string", length=3, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="PROCESSUS", type="string", length=4, nullable=false)
     */
    private $processus;

    /**
     * @var integer
     *
     * @ORM\Column(name="SEQNO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $seqno;

    /**
     * @var \AppBundle\Entity\Organs
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Organs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="OGN_CODE", referencedColumnName="CODE")
     * })
     */
    private $ognCode;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Necropsies", mappedBy="lteOgnCode")
     */
    private $ncyEseSeqno;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ncyEseSeqno = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
