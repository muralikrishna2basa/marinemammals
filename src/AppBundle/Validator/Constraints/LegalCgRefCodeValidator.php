<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use AppBundle\Form\ChoiceList\CgRefChoiceList;

abstract class LegalCgRefCodeValidator extends ConstraintValidator {

    protected $doctrine;

    protected $cgRefCodeDomain;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function validate($value, Constraint $constraint)
    {
        $cl=new CgRefChoiceList($this->doctrine, $this->cgRefCodeDomain);
        if ($value!== null and $value!== '' and !in_array($value,$cl->getChoices())) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%string%', $value)
                ->addViolation();
        }
    }
}
