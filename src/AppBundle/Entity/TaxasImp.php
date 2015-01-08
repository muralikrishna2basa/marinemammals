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



    /**
     * Set idodSeqno
     *
     * @param integer $idodSeqno
     * @return TaxasImp
     */
    public function setIdodSeqno($idodSeqno)
    {
        $this->idodSeqno = $idodSeqno;
    
        return $this;
    }

    /**
     * Get idodSeqno
     *
     * @return integer 
     */
    public function getIdodSeqno()
    {
        return $this->idodSeqno;
    }

    /**
     * Set taxas
     *
     * @param string $taxas
     * @return TaxasImp
     */
    public function setTaxas($taxas)
    {
        $this->taxas = $taxas;
    
        return $this;
    }

    /**
     * Get taxas
     *
     * @return string 
     */
    public function getTaxas()
    {
        return $this->taxas;
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
