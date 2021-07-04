<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\UserDetail;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserDetailFixtures extends Fixture
{


    public function load(ObjectManager $manager)
    {
        $commandNumber = 5;
        $faker = Factory::create('FR,fr');
        for ($i = 0; $i < $commandNumber; $i++) {
            $userDetail = new UserDetail();
            $userDetail->setLastname($faker->lastName());
            $userDetail->setFirstname($faker->firstName());
            $userDetail->setAddress($faker->streetAddress());
            $userDetail->setPostalCode($faker->postcode());
            $userDetail->setTown($faker->city());
            $userDetail->setCountry($faker->country());
            $userDetail->setPhone($faker->phoneNumber());

            $manager->persist($userDetail);
            $this->addReference('userDetail_' . $i, $userDetail);
        }
        $manager->flush();
    }
}
