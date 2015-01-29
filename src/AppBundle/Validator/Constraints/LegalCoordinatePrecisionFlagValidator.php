<?php

namespace AppBundle\Validator\Constraints;

class LegalCoordinatePrecisionFlagValidator extends LegalCgRefCodeValidator {

    public function __construct($doctrine)
    {
        parent::__construct($doctrine);
        $this->cgRefCodeDomain = 'COORDINATE_FLAG';
    }
}
