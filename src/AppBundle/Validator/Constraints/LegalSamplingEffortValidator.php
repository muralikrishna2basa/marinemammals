<?php

namespace AppBundle\Validator\Constraints;

class LegalSamplingEffortValidator extends LegalCgRefCodeValidator {

    public function __construct($doctrine)
    {
        parent::__construct($doctrine);
        $this->cgRefCodeDomain = 'SAMPLINGEFFORT';
    }
}
