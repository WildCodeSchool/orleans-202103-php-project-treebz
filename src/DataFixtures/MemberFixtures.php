<?php

namespace App\DataFixtures;

use App\Entity\Member;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MemberFixtures extends Fixture
{
    public const NB_FIXTURES = 6;
    public const MEMBERS = ['GRAND-PERE', 'GRAND-MERE', 'PAPA', 'MAMAN', 'FILS', 'FILLE', 'CHIEN'];
    public const LINK_IMAGE = "https://i.picsum.photos/id/1025/4951/3301.jpg?
    hmac=_aGh5AtoOChip_iaMo8ZvvytfEojcgqbCH7dzaz-H8Y";
    private const DIR_UPLOAD = '/uploads/members/';

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < self::NB_FIXTURES; $i++) {
            $member = new Member();
            $member->setName(self::MEMBERS[$i]);
            $urlImage = self::LINK_IMAGE;
            $path = uniqid() . '.jpg';
            copy($urlImage, 'public/uploads/members/' . $path);
            $imagePath = '/uploads/members/' . $path;
            $member->setPicture($imagePath);
            $manager->persist($member);
            $manager->flush();
        }
    }
}
