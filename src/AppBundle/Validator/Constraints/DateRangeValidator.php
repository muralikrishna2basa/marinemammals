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
        } else {

            if (null !== $constraint->max && $value > $constraint->max) {
                if (!is_string($value)) {
                    $valueStr = $value->format('Y-m-d H:i:s');
                }
                $this->context->buildViolation($constraint->maxMessage)->setParameter('{{ value }}', $valueStr)->setParameter('{{ limit }}', $this->formatDate($constraint->max))->addViolation();
            }

            if (null !== $constraint->min && $value < $constraint->min) {
                if (!is_string($value)) {
                    $valueStr = $value->format('Y-m-d H:i:s');
                }

                $this->context->buildViolation($constraint->minMessage)->setParameter('{{ value }}', $valueStr)->setParameter('{{ limit }}', $this->formatDate($constraint->min))->addViolation();
            }
        }
    }

    protected function formatDate($date)
    {
        $formatter = new \IntlDateFormatter(
            'nl-BE',
            \IntlDateFormatter::SHORT,
            \IntlDateFormatter::NONE,
            date_default_timezone_get(),
            \IntlDateFormatter::GREGORIAN
        );

        return $this->processDate($formatter, $date);
    }

    /**
     * @param  \IntlDateFormatter $formatter
     * @param  \Datetime $date
     * @return string
     */
    protected function processDate(\IntlDateFormatter $formatter, \Datetime $date)
    {
        return $formatter->format($date);
    }
}