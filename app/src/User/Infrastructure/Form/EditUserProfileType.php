<?php

namespace App\User\Infrastructure\Form;

use App\User\Domain\Model\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditUserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName', TextType::class, [
            'label' => 'Imię',
            'required' => false,
        ])
            ->add('lastName', TextType::class, [
                'label' => 'Nazwisko',
                'required' => false,
            ])
            ->add('address', TextType::class, [
                'label' => 'Adres',
                'required' => false,
            ])
            ->add('email', EmailType::class, [
                'disabled' => true,
            ])
            ->add('phoneNumber', IntegerType::class, [
                'label' => 'Numer telefonu',
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Zapisz',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
