<?php

declare(strict_types=1);

namespace Andante\ReCaptchaBundle\Validator\Constraint;

use Andante\ReCaptchaBundle\Service\ReCaptchaService;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ReCaptchaValidator extends ConstraintValidator
{
    private ReCaptchaService $recaptchaService;

    public function __construct(ReCaptchaService $recaptchaService)
    {
        $this->recaptchaService = $recaptchaService;
    }

    public function validate($value, Constraint $constraint): void
    {
        if (! $constraint instanceof ReCaptcha) {
            throw new UnexpectedTypeException($constraint, ReCaptcha::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (! is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }
        $response = $this->recaptchaService->verify($value);
        if (! $response->isSuccess()) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
