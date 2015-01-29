<?php

namespace AppBundle\Validator\Constraints;

class LegalParameterMethodOriginValidator extends LegalCgRefCodeValidator {

    public function __construct($doctrine)
    {
        parent::__construct($doctrine);
        $this->cgRefCodeDomain = 'PM_ORIGIN';
    }
}
