<?php

namespace AppBundle\Validator\Constraints;

class LegalEventDatetimeFlagValidator extends LegalCgRefCodeEntityValidator {

    public function __construct($doctrine)
    {
        parent::__construct($doctrine);
        $this->cgRefCodeDomain = 'DATETIME_FLAG';
    }
}
