<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LesionValues
 *
 * @ORM\Table(name="LESION_VALUES", indexes={@ORM\Index(name="lve_pmd_fk_i", columns={"PMD_SEQNO"}), @ORM\Index(name="lve_oln_fk_i", columns={"OLN_NCY_ESE_SEQNO", "OLN_LTE_OGN_CODE", "OLN_LTE_SEQNO"})})
 * @ORM\Entity
 */
class LesionValues
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
     * @ORM\SequenceGenerator(sequenceName="LESION_VALUES_SEQNO_seq", allocationSize=1, initialValue=1)
     */
    private $seqno;

    /**
     * @var \AppBundle\Entity\ParameterMethods
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ParameterMethods")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="PMD_SEQNO", referencedColumnName="SEQNO")
     * })
     */
    private $pmdSeqno;

    /**
     * @var \AppBundle\Entity\OrganLesions
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\OrganLesions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="OLN_NCY_ESE_SEQNO", referencedColumnName="NCY_ESE_SEQNO"),
     *   @ORM\JoinColumn(name="OLN_LTE_OGN_CODE", referencedColumnName="LTE_OGN_CODE"),
     *   @ORM\JoinColumn(name="OLN_LTE_SEQNO", referencedColumnName="LTE_SEQNO")
     * })
     */
    private $olnNcyEseSeqno;


}
