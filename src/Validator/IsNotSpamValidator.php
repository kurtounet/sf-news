<?php

namespace App\Validator;

use App\Service\SpamCheckerApi;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsNotSpamValidator extends ConstraintValidator
{
    public function __construct(private SpamCheckerApi $spamChecker)
    {

    }
    public function validate(mixed $value, Constraint $constraint): void
    {

        $isSpam = $this->spamChecker->isSpam($value);
        if (!$isSpam) {
            return;
        }

        // TODO: implement the validation here
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
