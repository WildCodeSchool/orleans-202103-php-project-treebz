<?php

namespace App\Form;

use App\Entity\ShippingAddress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ShippingAddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('address', TextType::class, [
            'label' => 'ADRESSE',
            'attr' => [
                'class' => 'form-control',
            ],
            'label_attr' => [
                'class' => 'form-label fw-bold'
            ]
        ])
        ->add('postalCode', TextType::class, [
            'label' => 'CODE POSTAL',
            'attr' => [
                'class' => 'form-control',
            ],
            'label_attr' => [
                'class' => 'form-label fw-bold'
            ]
        ])
        ->add('town', TextType::class, [
            'label' => 'VILLE',
            'attr' => [
                'class' => 'form-control',
            ],
            'label_attr' => [
                'class' => 'form-label fw-bold'
            ]
        ])
            ->add('country', CountryType::class, [
                'label' => 'PAYS',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label_attr' => [
                    'class' => 'form-label fw-bold'
                ]
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ShippingAddress::class,
        ]);
    }
}
