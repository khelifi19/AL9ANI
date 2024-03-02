<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ForbiddenWordsValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!is_string($value)) {
            return;
        }

        $forbiddenWords = ['israel', 'hitler', 'word3']; 

        foreach ($forbiddenWords as $forbiddenWord) {
            if (stripos($value, $forbiddenWord) !== false) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $value)
                    ->setParameter('{{ words }}', implode(', ', $forbiddenWords))
                    ->addViolation();
            }
        }
    }
}
