<?php

namespace App\DataFixtures;

use App\Entity\Command;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProjectFixtures extends Fixture
{
    public const NAMES = ['Stelmach', 'Silva', 'Olmedo', 'Lay', 'Vennier'];

    public function load(ObjectManager $manager)
    {
        foreach (self::NAMES as $name) {
            $command = new Command();
            $command->setProjectName($name);
            $manager->persist($command);
        }
        $manager->flush();
    }
}
