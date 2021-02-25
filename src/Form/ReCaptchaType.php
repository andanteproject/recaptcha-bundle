<?php

declare(strict_types=1);

namespace Andante\ReCaptchaBundle\Form;

use Andante\ReCaptchaBundle\Validator\Constraint\ReCaptcha;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ReCaptchaType extends AbstractType
{
    private string $siteKey;

    public function __construct(string $siteKey)
    {
        $this->siteKey = $siteKey;
    }

    public function getParent(): string
    {
        return HiddenType::class;
    }

    public function buildView(FormView $view, FormInterface $form, array $options) : void
    {
        $view->vars['size'] = $options['size'];
        $view->vars['theme'] = $options['theme'];
        $view->vars['value'] = '';
        $view->vars['g_recaptcha_site_key'] = $this->siteKey;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'trim' => false,
            'label' => false,
            'mapped' => false,
            'required' => true,
            'error_bubbling' => false,
            'theme' => 'light',
            'size' => 'normal',
            'constraints' => [
                new NotBlank(['message' => 'andante.recaptcha_type.not_blank.message']),
                new ReCaptcha()
            ],
        ]);
        $resolver->setAllowedValues('theme', ['dark', 'light']);
        $resolver->setAllowedValues('size', ['normal', 'compact']);
    }


    public function getBlockPrefix(): string
    {
        return 'andante_re_captcha';
    }
}
