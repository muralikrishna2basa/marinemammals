<?php

namespace AppBundle\Validator\Constraints;

class LegalOsnTypeValidator extends LegalCgRefCodeEntityValidator {

    public function __construct($doctrine)
    {
        parent::__construct($doctrine);
        $this->cgRefCodeDomain='OSN_TYPE';
    }
}
