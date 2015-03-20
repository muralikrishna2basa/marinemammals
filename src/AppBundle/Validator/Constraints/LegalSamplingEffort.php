<?php
namespace AppBundle\Validator\Constraints;

/**
 * @Annotation
 */
class LegalSamplingEffort extends LegalCgRefCodeEntity
{
    public function validatedBy()
    {
        return 'samplingeffort_indb';
    }
}
