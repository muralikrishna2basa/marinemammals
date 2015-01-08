<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ObservationValues
 *
 * @ORM\Table(name="OBSERVATION_VALUES", indexes={@ORM\Index(name="IDX_4746664D74D02126", columns={"ESE_SEQNO"}), @ORM\Index(name="IDX_4746664D5DC10EB5", columns={"PMD_SEQNO"})})
 * @ORM\Entity
 */
class ObservationValues
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
     * @ORM\SequenceGenerator(sequenceName="OBSERVATION_VALUES_SEQNO_seq", allocationSize=1, initialValue=1)
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
     * @var \AppBundle\Entity\Observations
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Observations")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ESE_SEQNO", referencedColumnName="ESE_SEQNO")
     * })
     */
    private $eseSeqno;


}
