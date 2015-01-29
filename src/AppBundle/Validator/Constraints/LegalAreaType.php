<?php
namespace AppBundle\Validator\Constraints;

/**
 * @Annotation
 */
class LegalAreaType extends LegalCgRefCode
{
    public function validatedBy()
    {
        return 'areatype_indb';
    }
}