<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Taxa
 *
 * @ORM\Table(name="TAXA", uniqueConstraints={@ORM\UniqueConstraint(name="uk_idod", columns={"IDOD_ID"}), @ORM\UniqueConstraint(name="uk_scientificnameauthorship", columns={"CANONICAL_NAME", "SCIENTIFIC_NAME_AUTHORSHIP"})})
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
     * @ORM\Column(name="TAXONRANK", type="string", length=30, nullable=true)
     */
    private $taxonrank;

    /**
     * @var string
     *
     * @ORM\Column(name="VERNACULAR_NAME_EN", type="string", length=50, nullable=true)
     */
    private $vernacularNameEn;

    /**
     * @var string
     *
     * @ORM\Column(name="VERNACULAR_NAME_NL", type="string", length=50, nullable=true)
     */
    private $vernacularNameNl;
    /**
     * @var string
     *
     * @ORM\Column(name="VERNACULAR_NAME_FR", type="string", length=50, nullable=true)
     */
    private $vernacularNameFr;

    /**
     * @var boolean
     *
     * @ORM\Column(name="PRESENT_IN_EUROPE", type="boolean", nullable=true)
     */
    private $presentInEurope;

    /**
     * @var boolean
     *
     * @ORM\Column(name="PRESENT_IN_NORTH_SEA", type="boolean", nullable=true)
     */
    private $presentInNorthSea;

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
     * @return string
     */
    public function getVernacularNameNl()
    {
        return $this->vernacularNameNl;
    }

    /**
     * @param string $vernacularNameNl
     * @return Taxa
     */
    public function setVernacularNameNl($vernacularNameNl)
    {
        $this->vernacularNameNl = $vernacularNameNl;
        return $this;
    }

    /**
     * @return string
     */
    public function getVernacularNameFr()
    {
        return $this->vernacularNameFr;
    }

    /**
     * @param string $vernacularNameFr
     * @return Taxa
     */
    public function setVernacularNameFr($vernacularNameFr)
    {
        $this->vernacularNameFr = $vernacularNameFr;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isPresentInNorthSea()
    {
        return $this->presentInNorthSea;
    }

    /**
     * @param boolean $presentInNorthSea
     * @return Taxa
     */
    public function setPresentInNorthSea($presentInNorthSea)
    {
        $this->presentInNorthSea = $presentInNorthSea;
        return $this;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Medias", mappedBy="txnSeqno")
     */
    private $medias;

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMedias()
    {
        return $this->medias;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $medias
     * @return Taxa
     */
    public function setMedias($medias)
    {
        $this->medias = $medias;
        return $this;
    }


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

    /**
     * @return boolean
     */
    public function isPresentInEurope()
    {
        return $this->presentInEurope;
    }

    /**
     * @param boolean $presentInEurope
     * @return Taxa
     */
    public function setPresentInEurope($presentInEurope)
    {
        $this->presentInEurope = $presentInEurope;
        return $this;
    }


    public function getFullyQualifiedName(){
        return $this->getCanonicalName().' ('.$this->getVernacularNameEn().')';
    }
}
