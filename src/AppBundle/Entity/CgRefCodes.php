<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CgRefCodes
 *
 * @ORM\Table(name="CG_REF_CODES", uniqueConstraints={@ORM\UniqueConstraint(name="cg_ref_codes_rv_meaning_uk", columns={"RV_MEANING"}),@ORM\UniqueConstraint(name="CG_REF_CODES_RV_LOW_UK", columns={"RV_DOMAIN","RV_LOW_VALUE"})}, indexes={@ORM\Index(name="x_cg_ref_codes_1", columns={"RV_DOMAIN", "RV_LOW_VALUE"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\CgRefCodesRepository")
 */
class CgRefCodes
{
    /**
     * @var string
     *
     * @ORM\Column(name="RV_ABBREVIATION", type="string", length=50, nullable=true)
     */
    private $rvAbbreviation;

    /**
     * @var string
     *
     * @ORM\Column(name="RV_DOMAIN", type="string", length=50, nullable=false)
     */
    private $rvDomain;

    /**
     * @var string
     *
     * @ORM\Column(name="RV_HIGH_VALUE", type="string", length=50, nullable=true)
     */
    private $rvHighValue;

    /**
     * @var string
     *
     * @ORM\Column(name="RV_LOW_VALUE", type="string", length=50, nullable=false)
     */
    private $rvLowValue;

    /**
     * @var string
     *
     * @ORM\Column(name="RV_MEANING", type="string", length=100, nullable=true)
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


    /**
     * Set rvAbbreviation
     *
     * @param string $rvAbbreviation
     * @return CgRefCodes
     */
    public function setRvAbbreviation($rvAbbreviation)
    {
        $this->rvAbbreviation = $rvAbbreviation;

        return $this;
    }

    /**
     * Get rvAbbreviation
     *
     * @return string
     */
    public function getRvAbbreviation()
    {
        return $this->rvAbbreviation;
    }

    /**
     * Set rvDomain
     *
     * @param string $rvDomain
     * @return CgRefCodes
     */
    public function setRvDomain($rvDomain)
    {
        $this->rvDomain = $rvDomain;

        return $this;
    }

    /**
     * Get rvDomain
     *
     * @return string
     */
    public function getRvDomain()
    {
        return $this->rvDomain;
    }

    /**
     * Set rvHighValue
     *
     * @param string $rvHighValue
     * @return CgRefCodes
     */
    public function setRvHighValue($rvHighValue)
    {
        $this->rvHighValue = $rvHighValue;

        return $this;
    }

    /**
     * Get rvHighValue
     *
     * @return string
     */
    public function getRvHighValue()
    {
        return $this->rvHighValue;
    }

    /**
     * Set rvLowValue
     *
     * @param string $rvLowValue
     * @return CgRefCodes
     */
    public function setRvLowValue($rvLowValue)
    {
        $this->rvLowValue = $rvLowValue;

        return $this;
    }

    /**
     * Get rvLowValue
     *
     * @return string
     */
    public function getRvLowValue()
    {
        return $this->rvLowValue;
    }

    /**
     * Set rvMeaning
     *
     * @param string $rvMeaning
     * @return CgRefCodes
     */
    public function setRvMeaning($rvMeaning)
    {
        $this->rvMeaning = $rvMeaning;

        return $this;
    }

    /**
     * Get rvMeaning
     *
     * @return string
     */
    public function getRvMeaning()
    {
        return $this->rvMeaning;
    }

    /**
     * Get seqno
     *
     * @return integer
     */
    public function getSeqno()
    {
        return $this->seqno;
    }
}
