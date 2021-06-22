<?php

namespace App\DataFixtures;

use App\Entity\Member;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

const NB_FIXTURES = 6;

class MemberFixtures extends Fixture
{


    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::NB_FIXTURES; $i++) {
            $member = new Member();
            $member->setName('member' . $i);
            $image = $faker->image('public/uploads/members', 360, 360, 'animals', false, true, 'cats', true);
            $member->setPicture($image);
            $manager->persist($member);
            $manager->flush();
        }
    }
}
