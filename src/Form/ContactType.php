<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                'label' => 'NOM:',
                'attr' => [
                    'required' => false,
                    'placeholder' => 'Simpson',
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => 'PRÉNOM:',
                'attr' => [
                    'required' => false,
                    'placeholder' => 'Marjorie',
                ]
            ])
            ->add('email', TextType::class, [
                'label' => 'ADRESSE EMAIL:',
                'attr' => [
                    'required' => false,
                    'placeholder' => 'marge.simpson@monmail.com',
                ]
            ])
            ->add('object', TextType::class, [
                'label' => 'OBJET:',
                'attr' => [
                    'required' => false,
                    'placeholder' => 'Question',
                ]
            ])
            ->add('message', TextareaType::class, [
                'label' => 'MESSAGE:',
                'attr' => [
                    'required' => false,
                    'placeholder' => 'Mon message.',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
