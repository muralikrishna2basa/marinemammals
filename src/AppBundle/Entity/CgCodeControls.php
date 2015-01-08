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



    /**
     * Set ccComment
     *
     * @param string $ccComment
     * @return CgCodeControls
     */
    public function setCcComment($ccComment)
    {
        $this->ccComment = $ccComment;
    
        return $this;
    }

    /**
     * Get ccComment
     *
     * @return string 
     */
    public function getCcComment()
    {
        return $this->ccComment;
    }

    /**
     * Set ccDomain
     *
     * @param string $ccDomain
     * @return CgCodeControls
     */
    public function setCcDomain($ccDomain)
    {
        $this->ccDomain = $ccDomain;
    
        return $this;
    }

    /**
     * Get ccDomain
     *
     * @return string 
     */
    public function getCcDomain()
    {
        return $this->ccDomain;
    }

    /**
     * Set ccIncrement
     *
     * @param integer $ccIncrement
     * @return CgCodeControls
     */
    public function setCcIncrement($ccIncrement)
    {
        $this->ccIncrement = $ccIncrement;
    
        return $this;
    }

    /**
     * Get ccIncrement
     *
     * @return integer 
     */
    public function getCcIncrement()
    {
        return $this->ccIncrement;
    }

    /**
     * Set ccNextValue
     *
     * @param integer $ccNextValue
     * @return CgCodeControls
     */
    public function setCcNextValue($ccNextValue)
    {
        $this->ccNextValue = $ccNextValue;
    
        return $this;
    }

    /**
     * Get ccNextValue
     *
     * @return integer 
     */
    public function getCcNextValue()
    {
        return $this->ccNextValue;
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
