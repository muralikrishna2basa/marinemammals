<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tevents
 *
 * @ORM\Table(name="TEVENTS")
 * @ORM\Entity
 */
class Tevents
{
    /**
     * @var string
     *
     * @ORM\Column(name="DATE", type="string", length=200, nullable=true)
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="ID", type="integer", nullable=true)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="LOCATION", type="string", length=200, nullable=true)
     */
    private $location;

    /**
     * @var string
     *
     * @ORM\Column(name="NOTE_EN", type="string", length=2000, nullable=true)
     */
    private $noteEn;

    /**
     * @var string
     *
     * @ORM\Column(name="NOTE_FR", type="string", length=2000, nullable=true)
     */
    private $noteFr;

    /**
     * @var string
     *
     * @ORM\Column(name="NOTE_NL", type="string", length=2000, nullable=true)
     */
    private $noteNl;

    /**
     * @var string
     *
     * @ORM\Column(name="PICTURE", type="string", length=200, nullable=true)
     */
    private $picture;

    /**
     * @var string
     *
     * @ORM\Column(name="SPECIES", type="string", length=200, nullable=true)
     */
    private $species;

    /**
     * @var string
     *
     * @ORM\Column(name="STATUS", type="string", length=200, nullable=true)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="TYPE", type="string", length=200, nullable=true)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="SEQNO", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="TEVENTS_SEQ", allocationSize=1, initialValue=1)
     */
    private $seqno;



    /**
     * Set date
     *
     * @param string $date
     * @return Tevents
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return string 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return Tevents
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set location
     *
     * @param string $location
     * @return Tevents
     */
    public function setLocation($location)
    {
        $this->location = $location;
    
        return $this;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set noteEn
     *
     * @param string $noteEn
     * @return Tevents
     */
    public function setNoteEn($noteEn)
    {
        $this->noteEn = $noteEn;
    
        return $this;
    }

    /**
     * Get noteEn
     *
     * @return string 
     */
    public function getNoteEn()
    {
        return $this->noteEn;
    }

    /**
     * Set noteFr
     *
     * @param string $noteFr
     * @return Tevents
     */
    public function setNoteFr($noteFr)
    {
        $this->noteFr = $noteFr;
    
        return $this;
    }

    /**
     * Get noteFr
     *
     * @return string 
     */
    public function getNoteFr()
    {
        return $this->noteFr;
    }

    /**
     * Set noteNl
     *
     * @param string $noteNl
     * @return Tevents
     */
    public function setNoteNl($noteNl)
    {
        $this->noteNl = $noteNl;
    
        return $this;
    }

    /**
     * Get noteNl
     *
     * @return string 
     */
    public function getNoteNl()
    {
        return $this->noteNl;
    }

    /**
     * Set picture
     *
     * @param string $picture
     * @return Tevents
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    
        return $this;
    }

    /**
     * Get picture
     *
     * @return string 
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set species
     *
     * @param string $species
     * @return Tevents
     */
    public function setSpecies($species)
    {
        $this->species = $species;
    
        return $this;
    }

    /**
     * Get species
     *
     * @return string 
     */
    public function getSpecies()
    {
        return $this->species;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Tevents
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Tevents
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
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
