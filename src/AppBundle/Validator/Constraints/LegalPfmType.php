<?php
namespace AppBundle\Validator\Constraints;

/**
 * @Annotation
 */
class LegalPfmType extends LegalCgRefCode
{
    public function validatedBy()
    {
        return 'pfmtype_indb';
    }
}