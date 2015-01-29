<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DecimalLatitudeValidator extends ConstraintValidator {

    public function validate($value, Constraint $constraint)
    {
        if (!preg_match('/^(\+|-)?(\d\.\d{1,6}|[1-8]\d\.\d{1,6}|90\.0{1,6})$/', $value, $matches)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%string%', $value)
                ->addViolation();

        }
    }
}
