<?php
namespace AppBundle\Validator\Constraints;

/**
 * @Annotation
 */
class LegalSex extends LegalCgRefCode
{
    public function validatedBy()
    {
        return 'sex_indb';
    }
}