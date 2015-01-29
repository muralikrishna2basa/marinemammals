<?php
namespace AppBundle\Validator\Constraints;

/**
 * @Annotation
 */
class LegalMediaType extends LegalCgRefCode
{
    public function validatedBy()
    {
        return 'mediatype_indb';
    }
}