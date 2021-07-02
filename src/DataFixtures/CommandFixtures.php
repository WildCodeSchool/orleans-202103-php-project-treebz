<?php

namespace App\DataFixtures;

use App\Entity\Command;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommandFixtures extends Fixture implements DependentFixtureInterface
{
    public const COMMANDS = [
        [
            'lastname' => 'Stelmach',
            'firstname' => 'Gersey',
            'address' => '1 avenue champs de mars',
            'postalCode' => '45000',
            'town' => 'Orléans',
            'country' => 'France',
            'phone' => '02 06 35 65 84',
            'email' => 'Stelmach@treebz.com',
            'quantity' => 2,
            'status' => 1
        ],
        [
            'lastname' => 'Blondeau',
            'firstname' => 'Sylva',
            'address' => '1 avenue champs de mars',
            'postalCode' => '45000',
            'town' => 'Orléans',
            'country' => 'France',
            'phone' => '01 04 98 45 36',
            'email' => 'Silva@treebz.com',
            'quantity' => 2,
            'status' => 1
        ],
        [
            'lastname' => 'Olmedo',
            'firstname' => 'Christian',
            'address' => '1 avenue champs de mars',
            'postalCode' => '45000',
            'town' => 'Orléans',
            'country' => 'France',
            'phone' => '03 45 95 67 84',
            'email' => 'Olmedo@treebz.com',
            'quantity' => 2,
            'status' => 1
        ],
        [
            'lastname' => 'Lay',
            'firstname' => 'Valentin',
            'address' => '1 avenue champs de mars',
            'postalCode' => '45000',
            'town' => 'Orléans',
            'country' => 'France',
            'phone' => '07 25 35 98 84',
            'email' => 'Lay@treebz.com',
            'quantity' => 5,
            'status' => 1
            // [
            //     'commandName' => 'Lay',
            //     'status' => 1
            // ]


        ],
        [
            'lastname' => 'Vennier',
            'firstname' => 'Aurélien',
            'address' => '1 avenue champs de mars',
            'postalCode' => '45000',
            'town' => 'Orléans',
            'country' => 'France',
            'phone' => '06 56 45 75 45',
            'email' => 'Vennier@treebz.com',
            'quantity' => 2,
            'status' => 1
        ]
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::COMMANDS as $keyCommand => $description) {
            $command = new Command();
            $command->setProjectName($description['lastname']);
            $command->setQuantity($description['quantity']);
            $command->setStatus($this->getReference('status_' . $description['status']));
            for ($i = 0; $i < count(ThemeFixtures::THEMES); $i++) {
                $command->addSelectedTheme($this->getReference('theme_' . $i));
            }
            $command->setContactInformation($this->getReference('userDetail_' . $keyCommand));
            $command->setUser($this->getReference('user_' . $keyCommand));

            $manager->persist($command);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            StatusFixtures::class,
            ThemeFixtures::class,
            UserFixtures::class,
            UserDetailFixtures::class
        ];
    }
}
