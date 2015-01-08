<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ParameterDomains
 *
 * @ORM\Table(name="PARAMETER_DOMAINS", indexes={@ORM\Index(name="IDX_E5226C6F5DC10EB5", columns={"PMD_SEQNO"})})
 * @ORM\Entity
 */
class ParameterDomains
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
     * @var string
     *
     * @ORM\Column(name="DESCRIPTION", type="string", length=4000, nullable=true)
     */
    private $description;

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
     * @ORM\Column(name="CODE", type="string", length=50)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $code;

    /**
     * @var \AppBundle\Entity\ParameterMethods
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\ParameterMethods")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="PMD_SEQNO", referencedColumnName="SEQNO")
     * })
     */
    private $pmdSeqno;


}
