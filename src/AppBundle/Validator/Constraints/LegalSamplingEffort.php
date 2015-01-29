<?php
namespace AppBundle\Validator\Constraints;

/**
 * @Annotation
 */
class LegalSamplingEffort extends LegalCgRefCode
{
    public function validatedBy()
    {
        return 'samplingeffort_indb';
    }
}
