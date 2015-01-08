<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpecimenValues
 *
 * @ORM\Table(name="SPECIMEN_VALUES", indexes={@ORM\Index(name="sve_s2e_fk_i", columns={"S2E_SCN_SEQNO", "S2E_ESE_SEQNO"}), @ORM\Index(name="sve_pmd_fk_i", columns={"PMD_SEQNO"}), @ORM\Index(name="sve_ese_i", columns={"S2E_ESE_SEQNO"})})
 * @ORM\Entity
 */
class SpecimenValues
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
     * @ORM\Column(name="DESCRIPTION", type="string", length=250, nullable=true)
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
     * @ORM\Column(name="VALUE", type="string", length=50, nullable=false)
     */
    private $value;

    /**
     * @var string
     *
     * @ORM\Column(name="VALUE_FLAG", type="string", length=1, nullable=true)
     */
    private $valueFlag;

    /**
     * @var integer
     *
     * @ORM\Column(name="SEQNO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="SPECIMEN_VALUES_SEQNO_seq", allocationSize=1, initialValue=1)
     */
    private $seqno;

    /**
     * @var \AppBundle\Entity\Spec2events
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Spec2events")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="S2E_SCN_SEQNO", referencedColumnName="SCN_SEQNO"),
     *   @ORM\JoinColumn(name="S2E_ESE_SEQNO", referencedColumnName="ESE_SEQNO")
     * })
     */
    private $s2eScnSeqno;

    /**
     * @var \AppBundle\Entity\ParameterMethods
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ParameterMethods")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="PMD_SEQNO", referencedColumnName="SEQNO")
     * })
     */
    private $pmdSeqno;


}
