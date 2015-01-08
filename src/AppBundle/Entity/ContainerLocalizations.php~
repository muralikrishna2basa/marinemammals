<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContainerLocalizations
 *
 * @ORM\Table(name="CONTAINER_LOCALIZATIONS", uniqueConstraints={@ORM\UniqueConstraint(name="cln_uk", columns={"CLN_SEQNO", "NAME", "CONTAINER_TYPE"})}, indexes={@ORM\Index(name="IDX_B611859EA0562FD1", columns={"CLN_SEQNO"})})
 * @ORM\Entity
 */
class ContainerLocalizations
{
    /**
     * @var string
     *
     * @ORM\Column(name="CONTAINER_TYPE", type="string", length=50, nullable=true)
     */
    private $containerType;

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
     * @ORM\Column(name="NAME", type="string", length=20, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="SEQNO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="CONTAINER_LOCALIZATIONS_SEQNO_", allocationSize=1, initialValue=1)
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


}
