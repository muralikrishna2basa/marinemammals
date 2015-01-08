<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CgRefCodes
 *
 * @ORM\Table(name="CG_REF_CODES", uniqueConstraints={@ORM\UniqueConstraint(name="cg_ref_codes_rv_meaning_uk", columns={"RV_MEANING"})}, indexes={@ORM\Index(name="x_cg_ref_codes_1", columns={"RV_DOMAIN", "RV_LOW_VALUE"})})
 * @ORM\Entity
 */
class CgRefCodes
{
    /**
     * @var string
     *
     * @ORM\Column(name="RV_ABBREVIATION", type="string", length=240, nullable=true)
     */
    private $rvAbbreviation;

    /**
     * @var string
     *
     * @ORM\Column(name="RV_DOMAIN", type="string", length=100, nullable=false)
     */
    private $rvDomain;

    /**
     * @var string
     *
     * @ORM\Column(name="RV_HIGH_VALUE", type="string", length=240, nullable=true)
     */
    private $rvHighValue;

    /**
     * @var string
     *
     * @ORM\Column(name="RV_LOW_VALUE", type="string", length=240, nullable=false)
     */
    private $rvLowValue;

    /**
     * @var string
     *
     * @ORM\Column(name="RV_MEANING", type="string", length=240, nullable=true)
     */
    private $rvMeaning;

    /**
     * @var integer
     *
     * @ORM\Column(name="SEQNO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="CG_REF_CODES_SEQNO_seq", allocationSize=1, initialValue=1)
     */
    private $seqno;


}
