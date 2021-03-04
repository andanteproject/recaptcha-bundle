![Andante Project Logo](https://github.com/andanteproject/recaptcha-bundle/blob/main/andanteproject-logo.png?raw=true)
# Google ReCAPTCHA Bundle 
#### Symfony Bundle - [AndanteProject](https://github.com/andanteproject)
[![Latest Version](https://img.shields.io/github/release/andanteproject/recaptcha-bundle.svg)](https://github.com/andanteproject/recaptcha-bundle/releases)
![Github actions](https://github.com/andanteproject/recaptcha-bundle/actions/workflows/workflow.yml/badge.svg?branch=main)
![Framework](https://img.shields.io/badge/Symfony-4.x|5.x-informational?Style=flat&logo=symfony)
![Php7](https://img.shields.io/badge/PHP-%207.4|8.x-informational?style=flat&logo=php)
![PhpStan](https://img.shields.io/badge/PHPStan-Level%208-syccess?style=flat&logo=php) 

A Symfony Bundle to easily integrate [Google reCAPTCHA](https://www.google.com/recaptcha/) into [Symfony Form](https://symfony.com/doc/current/forms.html). 

## Requirements
Symfony 4.x-5.x and PHP 7.4.

## Install
Via [Composer](https://getcomposer.org/):
```bash
$ composer require andanteproject/recaptcha-bundle
```

## Features
- Add [Google reCAPTCHA](https://www.google.com/recaptcha/) to your [Symfony Form](https://symfony.com/doc/current/forms.html) just like you do with every other `FormType`;
- Works like magic ✨.

## Install
After [install](#install), make sure you have the bundle registered in your symfony bundles list (`config/bundles.php`):
```php
return [
    /// bundles...
    Andante\ReCaptchaBundle\AndanteReCaptchaBundle::class => ['all' => true],
    /// bundles...
];
```
This should have been done automagically if you are using [Symfony Flex](https://flex.symfony.com). Otherwise, just register it by yourself.

## Configuration
Create a new `andante_re_captcha.yaml` configuration file and sets [Google ReCAPTCHA v2 `secret` and `site_key`](http://www.google.com/recaptcha/admin).
```yaml
andante_re_captcha:
  secret: 'put_here_your_google_recaptcha_v2_secret'
  site_key: 'put_here_your_google_recaptcha_v2_site_key'
```
### Dev/test environment Configuration 
**Please note:** If you don't want to be annoyed by recaptcha in your development/test environment, just use `secret key` and `site key` you can find in this [Google ReCAPTCHA documentation page](https://developers.google.com/recaptcha/docs/faq#id-like-to-run-automated-tests-with-recaptcha.-what-should-i-do).
Furthermore, you can create a `test` configuration to disable `Andante\ReCaptchaBundle\Validator\Constraint\ReCaptchaValidator` in `test` environment:
```yaml
andante_re_captcha:
  enable_validation: false #default: true
```

## Usage
After this, you can add `Andante\ReCaptchaBundle\Form\ReCaptchaType` Form type in your forms like you always do with other types.
```php
<?php
use Andante\ReCaptchaBundle\Form\ReCaptchaType;
use Symfony\Component\Form\AbstractType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ...
            // All your form fields
            // ...
            ->add('recaptcha', ReCaptchaType::class);
    }
}
```
**Done!** 🎉

You also have 2 options to change ReCAPTCHA _theme_ or _size_.
```php
$builder->add('recaptcha', ReCaptchaType::class, [
    'theme' => 'dark', // default is "light"
    'size' =>  'compact' // default is "normal"
]);
```
Using the option `'theme'` => `'dark'` is especially useful if your app has a dark mode.

## How to change validation process
Validation is handled by `Andante\ReCaptchaBundle\Validator\Constraint\ReCaptchaValidator`, which is a default constraint inside `ReCaptchaType` options.
If you want to replace it with your own or disable it for whatever reason, just empty/replace form type `constraints` option.
```php
$builder->add('recaptcha', ReCaptchaType::class, [
    'constraints' => [
        // Default value is Constraints\NotBlank + Constraint\Recaptcha 
    ]
]);
```

Built with love ❤️ by [AndanteProject](https://github.com/andanteproject) team.
