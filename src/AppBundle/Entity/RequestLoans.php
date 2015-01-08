<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RequestLoans
 *
 * @ORM\Table(name="REQUEST_LOANS")
 * @ORM\Entity
 */
class RequestLoans
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
     * @ORM\Column(name="DATE_OUT", type="datetime", nullable=true)
     */
    private $dateOut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_REQUEST", type="datetime", nullable=false)
     */
    private $dateRequest;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_RT", type="datetime", nullable=true)
     */
    private $dateRt;

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
     * @ORM\Column(name="STATUS", type="integer", nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="STUDY_DESCRIPTION", type="string", length=250, nullable=false)
     */
    private $studyDescription;

    /**
     * @var integer
     *
     * @ORM\Column(name="SEQNO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="REQUEST_LOANS_SEQNO_seq", allocationSize=1, initialValue=1)
     */
    private $seqno;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Samples", mappedBy="rlnSeqno")
     */
    private $speSeqno;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Persons", mappedBy="rlnSeqno")
     */
    private $psnSeqno;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->speSeqno = new \Doctrine\Common\Collections\ArrayCollection();
        $this->psnSeqno = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
