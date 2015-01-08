<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TaxasImp
 *
 * @ORM\Table(name="TAXAS_IMP")
 * @ORM\Entity
 */
class TaxasImp
{
    /**
     * @var integer
     *
     * @ORM\Column(name="IDOD_SEQNO", type="integer", nullable=false)
     */
    private $idodSeqno;

    /**
     * @var string
     *
     * @ORM\Column(name="TAXAS", type="string", length=50, nullable=false)
     */
    private $taxas;

    /**
     * @var integer
     *
     * @ORM\Column(name="SEQNO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="TAXAS_IMP_SEQNO_seq", allocationSize=1, initialValue=1)
     */
    private $seqno;


}
