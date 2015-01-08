<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CgCodeControls
 *
 * @ORM\Table(name="CG_CODE_CONTROLS")
 * @ORM\Entity
 */
class CgCodeControls
{
    /**
     * @var string
     *
     * @ORM\Column(name="CC_COMMENT", type="string", length=240, nullable=true)
     */
    private $ccComment;

    /**
     * @var string
     *
     * @ORM\Column(name="CC_DOMAIN", type="string", length=30, nullable=false)
     */
    private $ccDomain;

    /**
     * @var integer
     *
     * @ORM\Column(name="CC_INCREMENT", type="integer", nullable=true)
     */
    private $ccIncrement;

    /**
     * @var integer
     *
     * @ORM\Column(name="CC_NEXT_VALUE", type="integer", nullable=false)
     */
    private $ccNextValue;

    /**
     * @var integer
     *
     * @ORM\Column(name="SEQNO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="CG_CODE_CONTROLS_SEQNO_seq", allocationSize=1, initialValue=1)
     */
    private $seqno;


}
