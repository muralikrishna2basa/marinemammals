<?php

namespace AppBundle\Validator\Constraints;

class LegalMediaTypeValidator extends LegalCgRefCodeValidator {

    public function __construct($doctrine)
    {
        parent::__construct($doctrine);
        $this->cgRefCodeDomain = 'MEDIA_TYPE';
    }
}
