<?php
namespace AppBundle\Validator\Constraints;

/**
 * @Annotation
 */
class LegalEventDatetimeFlag extends LegalCgRefCode
{
    public function validatedBy()
    {
        return 'eventdatetimeflag_indb';
    }
}