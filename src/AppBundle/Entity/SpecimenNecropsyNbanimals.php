<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpecimenNecropsyNbanimals
 *
 * @ORM\Table(name="SPECIMEN_NECROPSY_NBANIMALS")
 * @ORM\Entity
 */
class SpecimenNecropsyNbanimals
{
    /**
     * @var integer
     *
     * @ORM\Column(name="DUMMY", type="integer", nullable=true)
     */
    private $dummy;

    /**
     * @var integer
     *
     * @ORM\Column(name="SEQNO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="SPECIMEN_NECROPSY_NBANIMALS_SE", allocationSize=1, initialValue=1)
     */
    private $seqno;



    /**
     * Set dummy
     *
     * @param integer $dummy
     * @return SpecimenNecropsyNbanimals
     */
    public function setDummy($dummy)
    {
        $this->dummy = $dummy;
    
        return $this;
    }

    /**
     * Get dummy
     *
     * @return integer 
     */
    public function getDummy()
    {
        return $this->dummy;
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
