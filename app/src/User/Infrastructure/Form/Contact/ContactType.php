<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Form\Contact;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', TextType::class, [
            'label' => 'Twój email'
        ])->add('name', TextType::class, [
            'label' => 'Twoje imię'
        ])->add('subject', TextType::class, [
            'label' => 'Tytuł emaila'
        ])->add('content', TextType::class, [
            'label' => 'Treść emaila'
        ])->add('submit', SubmitType::class, [
            'label' => 'Wyślij'
        ]);
    }
}