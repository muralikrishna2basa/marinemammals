<?php

namespace AppBundle\Validator\Constraints;

class LegalRequestLoanStatusValidator extends LegalCgRefCodeValidator {

    public function __construct($doctrine)
    {
        parent::__construct($doctrine);
        $this->cgRefCodeDomain = 'REQUEST_LOAN_STATUS';
    }
}
