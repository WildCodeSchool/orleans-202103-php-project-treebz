<?php

namespace App\Form;

use App\Entity\Command;
use App\Entity\ShippingAddress;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SelectAddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('shippingAddress', EntityType::class, [
                'label' => 'Choisissez l\'addresse de livraison',
                'class' => ShippingAddress::class,
                'choice_label' => function (ShippingAddress $fullAddresses) {
                    return  $fullAddresses->getFullAddresses();
                },
                'multiple' => false,
                'expanded' => false,
                'placeholder' => 'Choisissez une adresse',
                'required' => true,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('a')
                        ->where('a.user = :id')
                        ->setParameter('id', $options['user']->getId());
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Command::class,
            'user' => null,
        ]);
    }
}
