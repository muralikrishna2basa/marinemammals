<?php

namespace AppBundle\Validator\Constraints;

class LegalPlaceTypeValidator extends LegalCgRefCodeValidator {

    public function __construct($doctrine)
    {
        parent::__construct($doctrine);
        $this->cgRefCodeDomain = 'PLACE_TYPE';
    }
}
