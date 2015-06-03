<?php
namespace AppBundle\Form\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Samples;

class SeqnoJSONArrayToSampleArrayTransformer implements DataTransformerInterface
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * Transforms an ArrayCollection of Samples to a JSON array of seqnos.
     *
     * @param  \Doctrine\Common\Collections\ArrayCollection $sampleCollection
     * @return string
     */
    public function transform($sampleCollection)
    {
        if ($sampleCollection->isEmpty()) {
            return '[]';
        }

        $seqno = array();

        foreach ($sampleCollection as $sample) {
            array_push($seqno, $sample->getSeqno());
        }

        return json_encode($seqno);
    }

    /**
     * Transforms a JSON array of seqnos to an ArrayCollection of Samples.
     *
     * @param  String $seqnoString
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     *
     * @throws TransformationFailedException if one of the samples in the array is not found
     */
    public function reverseTransform($seqnoString)
    {
        if (!$seqnoString || $seqnoString='') {
            return null;
        }

        $seqnoArray=json_decode($seqnoString);

        $sampleCollection = new ArrayCollection();

        foreach($seqnoArray as $seqno ) {
            $sample = $this->doctrine->getRepository('AppBundle:Samples')
                ->findBySeqno($seqno);

            if (null === $sample) {
                throw new TransformationFailedException(sprintf(
                    'A sample with seqno "%s" does not exist!',
                    $seqno
                ));
            }
            $sampleCollection->add($sample);
        }

        return $sampleCollection;
    }
}