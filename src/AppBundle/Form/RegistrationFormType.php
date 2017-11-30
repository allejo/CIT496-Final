<?php

namespace AppBundle\Form;

use Carbon\Carbon;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

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
        ;
    }

    public function getParent()
    {
        return BaseType::class;
    }
}
