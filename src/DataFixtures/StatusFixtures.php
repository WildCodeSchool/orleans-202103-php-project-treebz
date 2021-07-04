<?php

namespace App\DataFixtures;

use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StatusFixtures extends Fixture
{
    public const STATUS = ['En cours', 'Livré', 'Annulé'];

    public function load(ObjectManager $manager)
    {
        foreach (self::STATUS as $key => $statement) {
            $status = new Status();
            $status->setName($statement);

            $manager->persist($status);
            $this->addReference('status_' . $key, $status);
        }

        $manager->flush();
    }
}
