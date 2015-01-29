<?php

namespace AppBundle\Validator\Constraints;

class LegalSexValidator extends LegalCgRefCodeValidator {

    public function __construct($doctrine)
    {
        parent::__construct($doctrine);
        $this->cgRefCodeDomain = 'SEX';
    }
}
