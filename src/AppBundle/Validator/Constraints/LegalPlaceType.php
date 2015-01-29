<?php
namespace AppBundle\Validator\Constraints;

/**
 * @Annotation
 */
class LegalPlaceType extends LegalCgRefCode
{
    public function validatedBy()
    {
        return 'placetype_indb';
    }
}