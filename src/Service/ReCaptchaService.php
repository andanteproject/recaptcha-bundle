<?php

declare(strict_types=1);

namespace Andante\ReCaptchaBundle\Service;

use ReCaptcha\ReCaptcha;
use ReCaptcha\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class ReCaptchaService
{
    private ReCaptcha $reCaptcha;
    private ?Request $request = null;

    public function __construct(string $secret, RequestStack $requestStack = null)
    {
        $this->reCaptcha = new ReCaptcha($secret);
        if (null !== $requestStack) {
            $this->request = $requestStack->getCurrentRequest();
        }
    }

    public function verify(string $response, string $remoteIp = null): Response
    {
        if (null === $remoteIp && null !== $this->request) {
            $remoteIp = $this->request->getClientIp();
        }
        return $this->reCaptcha->verify(
            $response,
            $remoteIp
        );
    }
}
