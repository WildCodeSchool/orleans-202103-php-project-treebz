<?php

namespace App\Form;

use App\Entity\Member;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class MemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du membre',
                'attr' => [
                    'required' => false,
                    'placeholder' => 'Grand-père, Grand-mère, Papa, ...',
                ]
            ])
            ->add('numberCard', TextType::class, [
                'label' => 'Numéro de la carte de jeu',
                'attr' => [
                    'required' => false,
                    'placeholder' => '1',
                ]
            ])
            ->add('pictureFile', VichFileType::class, [
                'label' => 'Chargement de l\'image',
                'required'     => false,
                'allow_delete' => true, // not mandatory, default is true
                'download_uri' => true, // not mandatory, default is true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
        ]);
    }
}
