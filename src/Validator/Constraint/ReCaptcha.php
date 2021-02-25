<?php

declare(strict_types=1);

namespace Andante\ReCaptchaBundle\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

class ReCaptcha extends Constraint
{
    public string $message = 'recaptcha_type.invalid_message';
}
