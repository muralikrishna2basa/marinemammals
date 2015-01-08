<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Specimens
 *
 * @ORM\Table(name="SPECIMENS", indexes={@ORM\Index(name="IDX_B15B2FF190063FB8", columns={"TXN_SEQNO"})})
 * @ORM\Entity
 */
class Specimens
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
     * @var integer
     *
     * @ORM\Column(name="MUMMTAG", type="integer", nullable=true)
     */
    private $mummtag;

    /**
     * @var integer
     *
     * @ORM\Column(name="MUMMTAGSERIE", type="integer", nullable=true)
     */
    private $mummtagserie;

    /**
     * @var string
     *
     * @ORM\Column(name="NECROPSY_TAG", type="string", length=14, nullable=true)
     */
    private $necropsyTag;

    /**
     * @var string
     *
     * @ORM\Column(name="RBINS_TAG", type="string", length=20, nullable=true)
     */
    private $rbinsTag;

    /**
     * @var integer
     *
     * @ORM\Column(name="SCN_NUMBER", type="integer", nullable=false)
     */
    private $scnNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="SEX", type="string", length=3, nullable=true)
     */
    private $sex;

    /**
     * @var string
     *
     * @ORM\Column(name="SPECIE_FLAG", type="string", length=1, nullable=true)
     */
    private $specieFlag;

    /**
     * @var integer
     *
     * @ORM\Column(name="SEQNO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="SPECIMENS_SEQNO_seq", allocationSize=1, initialValue=1)
     */
    private $seqno;

    /**
     * @var \AppBundle\Entity\Taxa
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Taxa")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="TXN_SEQNO", referencedColumnName="SEQNO")
     * })
     */
    private $txnSeqno;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\EventStates", mappedBy="scnSeqno")
     */
    private $eseSeqno;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->eseSeqno = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
