<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Taxa
 *
 * @ORM\Table(name="TAXA")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\TaxaRepository")
 */
class Taxa
{
    /**
     * @var string
     *
     * @ORM\Column(name="CANONICAL_NAME", type="string", length=50, nullable=true)
     */
    private $canonicalName;

    /**
     * @var integer
     *
     * @ORM\Column(name="IDOD_ID", type="integer", nullable=false)
     */
    private $idodId;

    /**
     * @var string
     *
     * @ORM\Column(name="SCIENTIFIC_NAME_AUTHORSHIP", type="string", length=50, nullable=true)
     */
    private $scientificNameAuthorship;

    /**
     * @var string
     *
     * @ORM\Column(name="TAXONRANK", type="string", length=50, nullable=true)
     */
    private $taxonrank;

    /**
     * @var string
     *
     * @ORM\Column(name="VERNACULAR_NAME_EN", type="string", length=50, nullable=true)
     */
    private $vernacularNameEn;

    /**
     * @var integer
     *
     * @ORM\Column(name="SEQNO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="taxa_seq", allocationSize=1, initialValue=1)
     */
    private $seqno;



    /**
     * Set canonicalName
     *
     * @param string $canonicalName
     * @return Taxa
     */
    public function setCanonicalName($canonicalName)
    {
        $this->canonicalName = $canonicalName;
    
        return $this;
    }

    /**
     * Get canonicalName
     *
     * @return string 
     */
    public function getCanonicalName()
    {
        return $this->canonicalName;
    }

    /**
     * Set idodId
     *
     * @param integer $idodId
     * @return Taxa
     */
    public function setIdodId($idodId)
    {
        $this->idodId = $idodId;
    
        return $this;
    }

    /**
     * Get idodId
     *
     * @return integer 
     */
    public function getIdodId()
    {
        return $this->idodId;
    }

    /**
     * Set scientificNameAuthorship
     *
     * @param string $scientificNameAuthorship
     * @return Taxa
     */
    public function setScientificNameAuthorship($scientificNameAuthorship)
    {
        $this->scientificNameAuthorship = $scientificNameAuthorship;
    
        return $this;
    }

    /**
     * Get scientificNameAuthorship
     *
     * @return string 
     */
    public function getScientificNameAuthorship()
    {
        return $this->scientificNameAuthorship;
    }

    /**
     * Set taxonrank
     *
     * @param string $taxonrank
     * @return Taxa
     */
    public function setTaxonrank($taxonrank)
    {
        $this->taxonrank = $taxonrank;
    
        return $this;
    }

    /**
     * Get taxonrank
     *
     * @return string 
     */
    public function getTaxonrank()
    {
        return $this->taxonrank;
    }

    /**
     * Set vernacularNameEn
     *
     * @param string $vernacularNameEn
     * @return Taxa
     */
    public function setVernacularNameEn($vernacularNameEn)
    {
        $this->vernacularNameEn = $vernacularNameEn;
    
        return $this;
    }

    /**
     * Get vernacularNameEn
     *
     * @return string 
     */
    public function getVernacularNameEn()
    {
        return $this->vernacularNameEn;
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
