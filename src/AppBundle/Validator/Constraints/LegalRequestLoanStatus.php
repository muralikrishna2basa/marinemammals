<?php
namespace AppBundle\Validator\Constraints;

/**
 * @Annotation
 */
class LegalRequestLoanStatus extends LegalCgRefCode
{
    public function validatedBy()
    {
        return 'requestloanstatus_indb';
    }
}