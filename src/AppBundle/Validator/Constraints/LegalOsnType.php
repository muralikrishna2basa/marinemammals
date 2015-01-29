<?php
namespace AppBundle\Validator\Constraints;

/**
 * @Annotation
 */
class LegalOsnType extends LegalCgRefCode
{
    public function validatedBy()
    {
        return 'osntype_indb';
    }
}
