<?php

namespace App\DataFixtures;

use App\Entity\Member;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\File;

class MemberFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $member = new Member();
        $member-> setName('papa');
        $member-> setPicture('portrait.jpg');
        $datetime = new DateTime('now');
        $member-> setUpdatedAt($datetime);
        $manager->persist($member);
        sleep(1);
        $member = new Member();
        $member-> setName('Grand-père');
        $member-> setPicture('portrait.jpg');
        $datetime = new DateTime('now');
        $member-> setUpdatedAt($datetime);
        $manager->persist($member);
        $manager->flush();
    }
}
