<?php

namespace App\DataFixtures;

use App\Entity\Command;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class CommandFixtures extends Fixture implements DependentFixtureInterface
{
    public const COMMANDS = [
        [
            'quantity' => 2,
            'status' => 1
        ],
        [
            'quantity' => 2,
            'status' => 1
        ],
    ];

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('FR,fr');
        foreach (self::COMMANDS as $keyCommand => $description) {
            $command = new Command();
            $command->setProjectName($faker->firstname());
            $command->setQuantity($description['quantity']);
            $command->setStatus($this->getReference('status_' . $description['status']));
            for ($i = 0; $i < count(ThemeFixtures::THEMES); $i++) {
                $command->addSelectedTheme($this->getReference('theme_' . $i));
            }
            $command->setPrice(24.99);
            $command->setContactInformation($this->getReference('userDetail_' . $keyCommand));
            $command->setUser($this->getReference('user_' . $keyCommand));
            $this->addReference('projet_' . $keyCommand, $command);
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
