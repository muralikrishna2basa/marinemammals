<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Necropsytag extends Constraint
{
    public $message = 'The string "%string%" is not a valid collection tag.';
}