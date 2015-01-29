<?php

namespace AppBundle\Validator\Constraints;

class LegalPfmTypeValidator extends LegalCgRefCodeValidator {

    public function __construct($doctrine)
    {
        parent::__construct($doctrine);
        $this->cgRefCodeDomain = 'PFM_TYPE';
    }
}
