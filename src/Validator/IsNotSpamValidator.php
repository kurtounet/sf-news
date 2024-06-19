<?php

namespace App\Validator;

use App\Service\SpamCheckerApi;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class IsNotSpamValidator extends ConstraintValidator
{
    public function __construct(
        private SpamCheckerApi $spamChecker
    ) {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof IsNotSpam) {
            throw new UnexpectedTypeException($constraint, IsNotSpam::class);
        }

        $isSpam = $this->spamChecker->isSpam($value);

        if (!$isSpam) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
