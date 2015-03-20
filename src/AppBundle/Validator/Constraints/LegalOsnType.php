<?php
namespace AppBundle\Validator\Constraints;

/**
 * @Annotation
 */
class LegalOsnType extends LegalCgRefCodeEntity
{
    public function validatedBy()
    {
        return 'osntype_indb';
    }
}
