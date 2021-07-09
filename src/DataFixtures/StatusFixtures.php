<?php

namespace App\DataFixtures;

use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StatusFixtures extends Fixture
{
    public const STATUS = [
        [
            'status' => 'En cours',
            'color' => 'light'
        ],
        [
            'status' => 'Commandée',
            'color' => 'danger'
        ],
        [
            'status' => 'Envoyée',
            'color' => 'primary'
        ],
        [
            'status' => 'Livrée',
            'color' => 'success'
        ],
        [
            'status' => 'Annulée',
            'color' => 'info'
        ]
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::STATUS as $key => $statement) {
            $status = new Status();
            $status->setName($statement['status']);
            $status->setColor($statement['color']);

            $manager->persist($status);
            $this->addReference('status_' . $key, $status);
        }

        $manager->flush();
    }
}
