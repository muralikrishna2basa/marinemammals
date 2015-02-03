<?php
namespace AppBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Specimens;

class EmptyToFalseTransformer implements DataTransformerInterface
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * Transforms an boolean false to an empty string.
     *
     * @param  boolean $boolean
     * @return string
     */
    public function transform($boolean)
    {
        if (false === $boolean) {
            return "";
        }

       // return $specimen->getSeqno();
    }

    /**
     * Transforms an empty string to a false boolean.
     *
     * @param  integer $seqno
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