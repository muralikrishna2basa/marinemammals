<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Necropsies
 *
 * @ORM\Table(name="NECROPSIES")
 * @ORM\Entity
 */
class Necropsies
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
     * @ORM\Column(name="PROGRAM", type="string", length=50, nullable=true)
     */
    private $program;

    /**
     * @var string
     *
     * @ORM\Column(name="REF_AUT", type="string", length=30, nullable=true)
     */
    private $refAut;

    /**
     * @var string
     *
     * @ORM\Column(name="REF_LABO", type="string", length=30, nullable=true)
     */
    private $refLabo;

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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\LesionTypes", mappedBy="ncyEseSeqno")
     */
    private $lteOgnCode;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lteOgnCode = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
