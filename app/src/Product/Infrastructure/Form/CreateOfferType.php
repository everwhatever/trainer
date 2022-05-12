<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Form;

use App\Product\Domain\Model\Offer;
use App\User\Domain\Model\AboutMe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CreateOfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('photo', FileType::class, [
            'label' => 'Zdjęcie (jpeg)',
            'mapped' => false,
            'required' => false,
            'constraints' => [
                new File([
                    'maxSize' => '2200k',
                    'mimeTypes' => [
                        'image/jpeg'
                    ],
                    'mimeTypesMessage' => 'Dodaj plik JPEG'
                ])
            ]
        ])
            ->add('name', TextType::class, [
                'label' => 'Nazwa',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Opis',
            ])
            ->add('price', IntegerType::class, [
                'label' => 'Cena'
            ])
            ->add('duration', TextType::class, [
                'label' => 'Czas trwania'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Zapisz'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
        ]);
    }
}