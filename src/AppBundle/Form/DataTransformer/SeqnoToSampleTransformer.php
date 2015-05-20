<?php
namespace AppBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Samples;

class SeqnoToSampleTransformer implements DataTransformerInterface
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * Transforms an object (Sample) to an integer.
     *
     * @param  Samples|null $sample
     * @return string
     */
    public function transform($sample)
    {
        if (null === $sample) {
            return "";
        }

        return $sample->getSeqno();
    }

    /**
     * Transforms a string (seqno) to an object (Sample).
     *
     * @param  integer $seqno
     *
     * @return Samples|null
     *
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($seqno)
    {
        if (!$seqno) {
            return null;
        }

        $sample = $this->doctrine->getRepository('AppBundle:Samples')
            ->findBySeqno($seqno);

        if (null === $sample) {
            throw new TransformationFailedException(sprintf(
                'A sample with seqno "%s" does not exist!',
                $seqno
            ));
        }

        return $sample;
    }
}