<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ForbiddenWords extends Constraint
{
    public $message = 'The text you just applied contains forbidden words.';
}