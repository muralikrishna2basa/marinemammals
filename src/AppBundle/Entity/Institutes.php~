<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Institutes
 *
 * @ORM\Table(name="INSTITUTES")
 * @ORM\Entity
 */
class Institutes
{
    /**
     * @var string
     *
     * @ORM\Column(name="CODE", type="string", length=15, nullable=false)
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
     * @ORM\Column(name="NAME", type="string", length=250, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="PSN_SEQNO", type="integer", nullable=true)
     */
    private $psnSeqno;

    /**
     * @var integer
     *
     * @ORM\Column(name="SEQNO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="INSTITUTES_SEQNO_seq", allocationSize=1, initialValue=1)
     */
    private $seqno;


}
