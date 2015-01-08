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


}
