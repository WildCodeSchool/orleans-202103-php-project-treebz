<?php

namespace App\DataFixtures;

use App\Entity\Member;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MemberFixtures extends Fixture implements DependentFixtureInterface
{

    public const MEMBERSNAME = ['GRAND-PERE', 'GRAND-MERE', 'PAPA', 'MAMAN', 'FILS', 'FILLE', 'CHIEN'];
    public const LINK_IMAGE = "https://i.picsum.photos/id/1025/4951/3301.jpg?
hmac=_aGh5AtoOChip_iaMo8ZvvytfEojcgqbCH7dzaz-H8Y";
    private const DIR_UPLOAD = '/uploads/members/';

    public function load(ObjectManager $manager)
    {
        for ($key = 0; $key < count(CommandFixtures::NAMES); $key++) {
            foreach (self::MEMBERSNAME as $memberName) {
                $member = new Member();
                $member->setCommand($this->getReference('projet_' . $key));
                $member->setName($memberName);
                $urlImage = self::LINK_IMAGE;
                $path = uniqid() . '.jpg';
                copy($urlImage, 'public/uploads/members/' . $path);
                $imagePath = $path;
                $member->setPicture($imagePath);
                $manager->persist($member);
                $manager->flush();
            }
        }
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
          CommandFixtures::class,
        ];
    }
}
