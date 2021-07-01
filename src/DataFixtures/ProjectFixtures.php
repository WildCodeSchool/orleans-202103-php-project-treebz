<?php

namespace App\DataFixtures;

use App\Entity\Command;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProjectFixtures extends Fixture implements DependentFixtureInterface
{
    public const NAMES = ['Stelmach', 'Martinez'];

    public function load(ObjectManager $manager)
    {
        foreach (self::NAMES as $key => $name) {
            $command = new Command();
            $command->setProjectName($name);
            $manager->persist($command);
            $this->addReference('projet_' . $key, $command);
            for ($key = 0; $key < count(ThemeFixtures::THEMES); $key) {
                $command->addSelectedTheme($this->getReference('theme_' . $key));
            }
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
          ThemeFixtures::class,
        ];
    }
}
