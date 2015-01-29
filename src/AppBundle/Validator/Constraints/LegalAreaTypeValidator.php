<?php

namespace AppBundle\Validator\Constraints;

class LegalAreaTypeValidator extends LegalCgRefCodeValidator {

    public function __construct($doctrine)
    {
        parent::__construct($doctrine);
        $this->cgRefCodeDomain = 'STN_AREA_TYPE';
    }
}
