<?php
namespace AppBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Specimens;

class SeqnoToSpecimenTransformer implements DataTransformerInterface
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * Transforms an object (Specimen) to a string (number).
     *
     * @param  Specimens|null $specimen
     * @return string
     */
    public function transform($specimen)
    {
        if (null === $specimen) {
            return "";
        }

        return (string)$specimen->getSeqno();
    }

    /**
     * Transforms a string (seqno) to an object (Specimen).
     *
     * @param  string $seqno
     *
     * @return Specimens|null
     *
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($seqno)
    {
        if (!$seqno) {
            return null;
        }

        $specimen = $this->doctrine->getRepository('AppBundle:Specimens')
            ->findOneBy(array('seqno' => $seqno));

        if (null === $specimen) {
            throw new TransformationFailedException(sprintf(
                'A specimen with seqno "%s" does not exist!',
                $seqno
            ));
        }

        return $specimen;
    }
}