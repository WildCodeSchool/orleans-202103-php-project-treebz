<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\UserDetail;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserDetailFixtures extends Fixture
{


    public function load(ObjectManager $manager)
    {
        foreach (CommandFixtures::COMMANDS as $key => $detail) {
            $userDetail = new UserDetail();
            $userDetail->setLastname($detail['lastname']);
            $userDetail->setFirstname($detail['firstname']);
            $userDetail->setAddress($detail['address']);
            $userDetail->setPostalCode($detail['postalCode']);
            $userDetail->setTown($detail['town']);
            $userDetail->setCountry($detail['country']);
            $userDetail->setPhone($detail['phone']);

            $manager->persist($userDetail);
            $this->addReference('userDetail_' . $key, $userDetail);
        }
        $manager->flush();
    }
}
