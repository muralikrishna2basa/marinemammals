<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SamplesImp
 *
 * @ORM\Table(name="SAMPLES_IMP")
 * @ORM\Entity
 */
class SamplesImp
{
    /**
     * @var string
     *
     * @ORM\Column(name="CONTAINER_TYPES__BOX", type="string", length=100, nullable=true)
     */
    private $containerTypesBox;

    /**
     * @var string
     *
     * @ORM\Column(name="CONTAINER_TYPES__INSTITUTE", type="string", length=100, nullable=true)
     */
    private $containerTypesInstitute;

    /**
     * @var string
     *
     * @ORM\Column(name="CONTAINER_TYPES__RANK", type="string", length=100, nullable=true)
     */
    private $containerTypesRank;

    /**
     * @var string
     *
     * @ORM\Column(name="COUNTRY", type="string", length=100, nullable=true)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="NECROPSIES_SUBREF", type="string", length=100, nullable=true)
     */
    private $necropsiesSubref;

    /**
     * @var string
     *
     * @ORM\Column(name="NECROPSIES__PROGRAM", type="string", length=100, nullable=true)
     */
    private $necropsiesProgram;

    /**
     * @var string
     *
     * @ORM\Column(name="NECROPSIES__REF_AUT", type="string", length=100, nullable=true)
     */
    private $necropsiesRefAut;

    /**
     * @var string
     *
     * @ORM\Column(name="NECROPSIES__REF_LABO", type="string", length=100, nullable=true)
     */
    private $necropsiesRefLabo;

    /**
     * @var string
     *
     * @ORM\Column(name="ORGANS__CODE", type="string", length=100, nullable=true)
     */
    private $organsCode;

    /**
     * @var string
     *
     * @ORM\Column(name="ORGAN_LESIONS__DESCRIPTION", type="string", length=4000, nullable=true)
     */
    private $organLesionsDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="SAMPLES__ANALYZE_DEST", type="string", length=100, nullable=true)
     */
    private $samplesAnalyzeDest;

    /**
     * @var string
     *
     * @ORM\Column(name="SAMPLES__CONSERVATION_MODE", type="string", length=100, nullable=true)
     */
    private $samplesConservationMode;

    /**
     * @var string
     *
     * @ORM\Column(name="SAMPLES__SPE_TYPE", type="string", length=100, nullable=true)
     */
    private $samplesSpeType;

    /**
     * @var integer
     *
     * @ORM\Column(name="SEQNO_TEMP", type="integer", nullable=true)
     */
    private $seqnoTemp;

    /**
     * @var integer
     *
     * @ORM\Column(name="SPECIMENS__IDOD_SEQNO", type="integer", nullable=true)
     */
    private $specimensIdodSeqno;

    /**
     * @var string
     *
     * @ORM\Column(name="SPECIMENS__TAXA", type="string", length=300, nullable=true)
     */
    private $specimensTaxa;

    /**
     * @var integer
     *
     * @ORM\Column(name="SEQNO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="SAMPLES_IMP_SEQNO_seq", allocationSize=1, initialValue=1)
     */
    private $seqno;



    /**
     * Set containerTypesBox
     *
     * @param string $containerTypesBox
     * @return SamplesImp
     */
    public function setContainerTypesBox($containerTypesBox)
    {
        $this->containerTypesBox = $containerTypesBox;
    
        return $this;
    }

    /**
     * Get containerTypesBox
     *
     * @return string 
     */
    public function getContainerTypesBox()
    {
        return $this->containerTypesBox;
    }

    /**
     * Set containerTypesInstitute
     *
     * @param string $containerTypesInstitute
     * @return SamplesImp
     */
    public function setContainerTypesInstitute($containerTypesInstitute)
    {
        $this->containerTypesInstitute = $containerTypesInstitute;
    
        return $this;
    }

    /**
     * Get containerTypesInstitute
     *
     * @return string 
     */
    public function getContainerTypesInstitute()
    {
        return $this->containerTypesInstitute;
    }

    /**
     * Set containerTypesRank
     *
     * @param string $containerTypesRank
     * @return SamplesImp
     */
    public function setContainerTypesRank($containerTypesRank)
    {
        $this->containerTypesRank = $containerTypesRank;
    
        return $this;
    }

    /**
     * Get containerTypesRank
     *
     * @return string 
     */
    public function getContainerTypesRank()
    {
        return $this->containerTypesRank;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return SamplesImp
     */
    public function setCountry($country)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set necropsiesSubref
     *
     * @param string $necropsiesSubref
     * @return SamplesImp
     */
    public function setNecropsiesSubref($necropsiesSubref)
    {
        $this->necropsiesSubref = $necropsiesSubref;
    
        return $this;
    }

    /**
     * Get necropsiesSubref
     *
     * @return string 
     */
    public function getNecropsiesSubref()
    {
        return $this->necropsiesSubref;
    }

    /**
     * Set necropsiesProgram
     *
     * @param string $necropsiesProgram
     * @return SamplesImp
     */
    public function setNecropsiesProgram($necropsiesProgram)
    {
        $this->necropsiesProgram = $necropsiesProgram;
    
        return $this;
    }

    /**
     * Get necropsiesProgram
     *
     * @return string 
     */
    public function getNecropsiesProgram()
    {
        return $this->necropsiesProgram;
    }

    /**
     * Set necropsiesRefAut
     *
     * @param string $necropsiesRefAut
     * @return SamplesImp
     */
    public function setNecropsiesRefAut($necropsiesRefAut)
    {
        $this->necropsiesRefAut = $necropsiesRefAut;
    
        return $this;
    }

    /**
     * Get necropsiesRefAut
     *
     * @return string 
     */
    public function getNecropsiesRefAut()
    {
        return $this->necropsiesRefAut;
    }

    /**
     * Set necropsiesRefLabo
     *
     * @param string $necropsiesRefLabo
     * @return SamplesImp
     */
    public function setNecropsiesRefLabo($necropsiesRefLabo)
    {
        $this->necropsiesRefLabo = $necropsiesRefLabo;
    
        return $this;
    }

    /**
     * Get necropsiesRefLabo
     *
     * @return string 
     */
    public function getNecropsiesRefLabo()
    {
        return $this->necropsiesRefLabo;
    }

    /**
     * Set organsCode
     *
     * @param string $organsCode
     * @return SamplesImp
     */
    public function setOrgansCode($organsCode)
    {
        $this->organsCode = $organsCode;
    
        return $this;
    }

    /**
     * Get organsCode
     *
     * @return string 
     */
    public function getOrgansCode()
    {
        return $this->organsCode;
    }

    /**
     * Set organLesionsDescription
     *
     * @param string $organLesionsDescription
     * @return SamplesImp
     */
    public function setOrganLesionsDescription($organLesionsDescription)
    {
        $this->organLesionsDescription = $organLesionsDescription;
    
        return $this;
    }

    /**
     * Get organLesionsDescription
     *
     * @return string 
     */
    public function getOrganLesionsDescription()
    {
        return $this->organLesionsDescription;
    }

    /**
     * Set samplesAnalyzeDest
     *
     * @param string $samplesAnalyzeDest
     * @return SamplesImp
     */
    public function setSamplesAnalyzeDest($samplesAnalyzeDest)
    {
        $this->samplesAnalyzeDest = $samplesAnalyzeDest;
    
        return $this;
    }

    /**
     * Get samplesAnalyzeDest
     *
     * @return string 
     */
    public function getSamplesAnalyzeDest()
    {
        return $this->samplesAnalyzeDest;
    }

    /**
     * Set samplesConservationMode
     *
     * @param string $samplesConservationMode
     * @return SamplesImp
     */
    public function setSamplesConservationMode($samplesConservationMode)
    {
        $this->samplesConservationMode = $samplesConservationMode;
    
        return $this;
    }

    /**
     * Get samplesConservationMode
     *
     * @return string 
     */
    public function getSamplesConservationMode()
    {
        return $this->samplesConservationMode;
    }

    /**
     * Set samplesSpeType
     *
     * @param string $samplesSpeType
     * @return SamplesImp
     */
    public function setSamplesSpeType($samplesSpeType)
    {
        $this->samplesSpeType = $samplesSpeType;
    
        return $this;
    }

    /**
     * Get samplesSpeType
     *
     * @return string 
     */
    public function getSamplesSpeType()
    {
        return $this->samplesSpeType;
    }

    /**
     * Set seqnoTemp
     *
     * @param integer $seqnoTemp
     * @return SamplesImp
     */
    public function setSeqnoTemp($seqnoTemp)
    {
        $this->seqnoTemp = $seqnoTemp;
    
        return $this;
    }

    /**
     * Get seqnoTemp
     *
     * @return integer 
     */
    public function getSeqnoTemp()
    {
        return $this->seqnoTemp;
    }

    /**
     * Set specimensIdodSeqno
     *
     * @param integer $specimensIdodSeqno
     * @return SamplesImp
     */
    public function setSpecimensIdodSeqno($specimensIdodSeqno)
    {
        $this->specimensIdodSeqno = $specimensIdodSeqno;
    
        return $this;
    }

    /**
     * Get specimensIdodSeqno
     *
     * @return integer 
     */
    public function getSpecimensIdodSeqno()
    {
        return $this->specimensIdodSeqno;
    }

    /**
     * Set specimensTaxa
     *
     * @param string $specimensTaxa
     * @return SamplesImp
     */
    public function setSpecimensTaxa($specimensTaxa)
    {
        $this->specimensTaxa = $specimensTaxa;
    
        return $this;
    }

    /**
     * Get specimensTaxa
     *
     * @return string 
     */
    public function getSpecimensTaxa()
    {
        return $this->specimensTaxa;
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
