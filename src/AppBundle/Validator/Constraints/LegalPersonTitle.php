<?php
namespace AppBundle\Validator\Constraints;

/**
 * @Annotation
 */
class LegalPersonTitle extends LegalCgRefCode
{
    public function validatedBy()
    {
        return 'persontitle_indb';
    }
}