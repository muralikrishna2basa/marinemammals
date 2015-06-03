<?php
namespace AppBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class SeqnoStringToSampleArrayTransformer
 * @package AppBundle\Form\DataTransformer
 *
 * A class to convert an array of sample seqnos to an array of samples
 */
class SeqnoStringToSampleArrayTransformer implements DataTransformerInterface
{
    /**
     * Transforms an array of seqnos to a concatenated string of the seqnos
     *
     * @param  array|null $seqnoArray
     * @return String
     */
    public function transform($seqnoArray)
    {
        if (!$seqnoArray) {
            $seqnoArray = array(); // default value
        }

        return implode(', ', $seqnoArray); // concatenate the seqnoes to one string
    }

    /**
     * Transforms a string of seqnos to an array of seqnos
     *
     * @param  String|null $seqnoString
     * @return array
     */
    public function reverseTransform($seqnoString)
    {
        if (!$seqnoString) {
            $seqnoString = ''; // default
        }

        return array_filter(array_map('trim', explode(',', $seqnoString)));
// 1. Split the string with commas
// 2. Remove whitespaces around the tags
// 3. Remove empty elements (like in "tag1,tag2, ,,tag3,tag4")
    }
}