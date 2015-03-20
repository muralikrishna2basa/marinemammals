<?php

namespace AppBundle\Validator\Constraints;

class LegalSamplingEffortValidator extends LegalCgRefCodeEntityValidator {

    public function __construct($doctrine)
    {
        parent::__construct($doctrine);
        $this->cgRefCodeDomain = 'SAMPLINGEFFORT';
    }
}
