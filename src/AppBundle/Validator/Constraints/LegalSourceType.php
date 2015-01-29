<?php
namespace AppBundle\Validator\Constraints;

/**
 * @Annotation
 */
class LegalSourceType extends LegalCgRefCode
{
    public function validatedBy()
    {
        return 'sourcetype_indb';
    }
}