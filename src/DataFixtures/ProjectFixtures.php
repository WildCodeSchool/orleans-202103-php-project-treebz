<?php

namespace App\DataFixtures;

use App\Entity\Command;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProjectFixtures extends Fixture implements DependentFixtureInterface
{
    public const COMMANDS = [
        'Stelmach' => [
            'quantity' => '1',
            'status' => 'En cours'
        ],
        'Silva' => [
            'quantity' => '2',
            'status' => 'En cours'
        ],
        'Olmedo' => [
            'quantity' => '1',
            'status' => 'Livré'
        ],
        'Lay' => [
            'quantity' => '6',
            'status' => 'Livré'
        ],
        'Vennier' => [
            'quantity' => '1',
            'status' => 'Annuler'
        ]
    ];

    public function load(ObjectManager $manager)
    {
        // foreach (UserDetailFixtures::USER_DETAILS as $detail) {
        // foreach (ThemeFixtures::THEMES as $numberTheme) {
        foreach (UserFixtures::USER as $number) {
            foreach (self::COMMANDS as $name => $description) {
                $command = new Command();
                $command->setProjectName($name);
                $command->setQuantity($description['quantity']);
                $command->setStatus($this->getReference('status_' . $description['status']));
                // for ($i = 0; $i < count(ThemeFixtures::THEMES); $i++) {
                //     $command->addSelectedTheme($this->getReference('theme_' . $numberTheme));
                // }
                // $command->setContactInformation($this->getReference('userDetail_' . $detail));
                $command->setUser($this->getReference('user_' . $number));

                $manager->persist($command);
            }
            // }
            // }
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
