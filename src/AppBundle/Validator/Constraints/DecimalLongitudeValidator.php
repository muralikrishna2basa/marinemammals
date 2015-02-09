<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DecimalLongitudeValidator extends ConstraintValidator {

    public function validate($value, Constraint $constraint)
    {
        if (!preg_match('/^$|^(\+|-)?([0-9][0-9]?\.\d{1,6}|1[0-7][0-9]\.\d{1,6}|180\.\d{1,6})$/', $value, $matches)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%string%', $value)
                ->addViolation();

        }
    }
}
