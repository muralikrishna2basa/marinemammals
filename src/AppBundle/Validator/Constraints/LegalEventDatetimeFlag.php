<?php
namespace AppBundle\Validator\Constraints;

/**
 * @Annotation
 */
class LegalEventDatetimeFlag extends LegalCgRefCodeEntity
{
    public function validatedBy()
    {
        return 'eventdatetimeflag_indb';
    }
}