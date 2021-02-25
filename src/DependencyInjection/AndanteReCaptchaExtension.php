<?php

declare(strict_types=1);

namespace Andante\ReCaptchaBundle\DependencyInjection;

use Andante\ReCaptchaBundle\Form\ReCaptchaType;
use Andante\ReCaptchaBundle\Service\ReCaptchaService;
use Andante\ReCaptchaBundle\Validator\Constraint\ReCaptchaValidator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpFoundation\RequestStack;

class AndanteReCaptchaExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container) : void
    {
        $config = $this->processConfiguration(new Configuration(), $configs);
        $container
            ->setDefinition(
                'andante_re_captcha.form_type.recaptcha_type',
                new Definition(ReCaptchaType::class)
            )
            ->addArgument($config['site_key'])
            ->addTag('form.type');

        $container
            ->setDefinition(
                'andante_re_captcha.validator.recaptcha_validator',
                new Definition(ReCaptchaValidator::class)
            )
            ->addArgument(new Reference('andante_re_captcha.service.recaptcha'))
            ->addTag('validator.constraint_validator', ['alias' => 'recaptcha']);

        $container
            ->setDefinition(
                'andante_re_captcha.service.recaptcha',
                new Definition(ReCaptchaService::class)
            )
            ->addArgument($config['secret'])
            ->addArgument(new Reference(RequestStack::class));
    }

    public function prepend(ContainerBuilder $container): void
    {
        if ($container->hasExtension('twig')) {
            $container->prependExtensionConfig('twig', [
                'form_themes' => [
                    '@AndanteReCaptcha/Form/fields.html.twig',
                ],
            ]);
        }
    }

    public function getAlias() : string
    {
        return 'andante_re_captcha';
    }
}
