<?php
namespace AppBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Groups;

class SeqnoToGroupTransformer implements DataTransformerInterface
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * Transforms an object (group) to a string (number).
     *
     * @param  Groups|null $group
     * @return string
     */
    public function transform($group)
    {
        if (null === $group) {
            return "";
        }

        return $group->getName();
    }

    /**
     * Transforms a string (number) to an object (group).
     *
     * @param  string $name
     * @return Groups|null
     * @throws TransformationFailedException if object (group) is not found.
     */
    public function reverseTransform($name)
    {
        if (!$name) {
            return null;
        }
        $group = $this->doctrine->getRepository('AppBundle:Groups')->findByName($name);
        if (null === $group) {
            throw new TransformationFailedException(sprintf(
                'Group with name "%s" does not exist!',
                $name
            ));
        }
        return $group;
    }
}