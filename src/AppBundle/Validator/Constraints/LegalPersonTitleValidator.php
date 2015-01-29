<?php

namespace AppBundle\Validator\Constraints;

class LegalPersonTitleValidator extends LegalCgRefCodeValidator {

    public function __construct($doctrine)
    {
        parent::__construct($doctrine);
        $this->cgRefCodeDomain = 'PSN_TITLE';
    }
}
