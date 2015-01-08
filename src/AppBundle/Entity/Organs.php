<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Organs
 *
 * @ORM\Table(name="ORGANS", indexes={@ORM\Index(name="ogn_ogn_fk_i", columns={"OGN_CODE"})})
 * @ORM\Entity
 */
class Organs
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
     * @ORM\Column(name="NAME", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="CODE", type="string", length=10)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="ORGANS_CODE_seq", allocationSize=1, initialValue=1)
     */
    private $code;

    /**
     * @var \AppBundle\Entity\Organs
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="OGN_CODE", referencedColumnName="CODE")
     * })
     */
    private $ognCode;


}
