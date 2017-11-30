<?php

namespace AppBundle\Form;

use Carbon\Carbon;
use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\IsTrue as RecaptchaTrue;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $now = Carbon::now();

        $builder
            ->add('firstName', TextType::class, [])
            ->add('lastName', TextType::class, [])
            ->add('birthday', BirthdayType::class, [
                'years' => array_reverse(range(1900, $now->year - 13))
            ])
            ->add('recaptcha', EWZRecaptchaType::class, [
                'mapped' => false,
                'constraints' => [
                    new RecaptchaTrue()
                ]
            ])
        ;
    }

    public function getParent()
    {
        return BaseType::class;
    }
}
