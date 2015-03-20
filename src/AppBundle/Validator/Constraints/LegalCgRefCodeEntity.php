<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
abstract class LegalCgRefCodeEntity extends Constraint
{
    public $message = 'The value "%string%" is not defined in the database as a valid value for this parameter.';
}
