<?php

namespace AppBundle\Validator\Constraints;

class LegalSourceTypeValidator extends LegalCgRefCodeValidator {

    public function __construct($doctrine)
    {
        parent::__construct($doctrine);
        $this->cgRefCodeDomain = 'SOURCE_TYPE';
    }
}
