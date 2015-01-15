<?php

namespace AppBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

use AppBundle\Entity\Specimens;
use AppBundle\Form\DataTransformer\SpecimensSelector;

class SpecimensTransformer implements DataTransformerInterface
{
    private $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * Transforms a Specimens object to a choice in a SpecimensSelector object
     *
     * @param  Specimens $specimens
     * @return SpecimensSelector|null
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function transform($specimens)
    {
        if (!$specimens) {
            return null;
        }
        $specimensSelector = new SpecimensSelector($specimens);

        return $specimensSelector;
    }

    /**
     * Transforms a SpecimensSelector object to the selected Specimens object
     *
     * @param  SpecimensSelector|null $selector
     * @return string
     */
    public function  reverseTransform($selector)
    {
        if (null === $selector) {
            return "";
        }

        return $selector->getSpecimens();
    }


}