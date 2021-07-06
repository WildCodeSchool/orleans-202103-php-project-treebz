<?php

namespace App\Form;

use App\Entity\UserDetail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\RegistrationFormType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class UserDetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('lastname', TextType::class, [
                'label' => 'NOM',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label_attr' => [
                    'class' => 'form-label fw-bold'
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => 'PRÉNOM',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label_attr' => [
                    'class' => 'form-label fw-bold'
                ]
            ])
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
            ->add('country', TextType::class, [
                'label' => 'PAYS',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label_attr' => [
                    'class' => 'form-label fw-bold'
                ]
            ])
            ->add('phone', TextType::class, [
                'label' => 'NUMÉRO DE TÉLÉPHONE',
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
            'data_class' => UserDetail::class,
        ]);
    }
}
