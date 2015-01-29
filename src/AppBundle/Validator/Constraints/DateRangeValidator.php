<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DateRangeValidator extends ConstraintValidator
{
    /**
     * {@inheritDoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (null === $value) {
            return;
        }

        if (!($value instanceof \DateTime)) {
            $this->context->buildViolation($constraint->invalidMessage)->setParameter('{{ value }}', $value)->addViolation();
        }

        if (null !== $constraint->max && $value > $constraint->max) {
            $this->context->buildViolation($constraint->maxMessage)->setParameter('{{ value }}', $value)->setParameter('{{ limit }}', $this->formatDate($constraint->max))->addViolation();
        }

        if (null !== $constraint->min && $value < $constraint->min) {
            $this->context->buildViolation($constraint->minMessage)->setParameter('{{ value }}', $value)->setParameter('{{ limit }}', $this->formatDate($constraint->min))->addViolation();
        }
    }

    protected function formatDate($date)
    {
        $formatter = new \IntlDateFormatter(
            null,
            \IntlDateFormatter::SHORT,
            \IntlDateFormatter::NONE,
            date_default_timezone_get(),
            \IntlDateFormatter::GREGORIAN
        );

        return $this->processDate($formatter, $date);
    }

    /**
     * @param  \IntlDateFormatter $formatter
     * @param  \Datetime          $date
     * @return string
     */
    protected function processDate(\IntlDateFormatter $formatter, \Datetime $date)
    {
        return $formatter->format((int) $date->format('U'));
    }
}