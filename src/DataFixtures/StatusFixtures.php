<?php

namespace App\DataFixtures;

use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StatusFixtures extends Fixture
{
    public const STATUS = ['En cours', 'Livré', 'Annuler'];

    public function load(ObjectManager $manager)
    {
        foreach (self::STATUS as $statement) {
            $status = new Status();
            $status->setName($statement);

            $manager->persist($status);
            $this->addReference('status_' . $statement, $status);
        }

        $manager->flush();
    }
}
