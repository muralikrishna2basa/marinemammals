<?php
namespace AppBundle\Validator\Constraints;

/**
 * @Annotation
 */
class LegalCoordinatePrecisionFlag extends LegalCgRefCode
{
    public function validatedBy()
    {
        return 'coordinateprecisionflag_indb';
    }
}