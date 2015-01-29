<?php
namespace AppBundle\Validator\Constraints;

/**
 * @Annotation
 */
class LegalParameterMethodOrigin extends LegalCgRefCode
{
    public function validatedBy()
    {
        return 'parametermethodorigin_indb';
    }
}