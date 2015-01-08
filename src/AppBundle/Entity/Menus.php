<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Menus
 *
 * @ORM\Table(name="MENUS")
 * @ORM\Entity
 */
class Menus
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
     * @ORM\Column(name="DESCRIPTION", type="string", length=400, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="DISPLAY", type="string", length=1, nullable=true)
     */
    private $display;

    /**
     * @var integer
     *
     * @ORM\Column(name="DISPLAY_ORDER", type="integer", nullable=true)
     */
    private $displayOrder;

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
     * @ORM\Column(name="NAME", type="string", length=200, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="SCRIPT", type="string", length=100, nullable=false)
     */
    private $script;

    /**
     * @var integer
     *
     * @ORM\Column(name="SEQNO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="MENUS_SEQNO_seq", allocationSize=1, initialValue=1)
     */
    private $seqno;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Groups", mappedBy="mnuSeqno")
     */
    private $grpName;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->grpName = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
