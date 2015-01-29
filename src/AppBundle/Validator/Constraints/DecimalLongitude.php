<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class DecimalLongitude extends Constraint
{
    public $message = 'The number "%string%" is not a valid decimal longitude.';
}