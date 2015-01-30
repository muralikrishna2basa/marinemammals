<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NecropsytagValidator extends ConstraintValidator {

    public function validate($value, Constraint $constraint)
    {
        if (!preg_match('/^$|^[a-zA-Z]{2}[_|-]{1}[0-9]{4}[_|-]{1}[0-9]{1,6}$/', $value, $matches)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%string%', $value)
                ->addViolation();

        }
    }
}
