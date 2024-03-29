<?php

namespace App\DataFixtures;

use App\Entity\Member;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MemberFixtures extends Fixture implements DependentFixtureInterface
{
// @codingStandardsIgnoreStart
    public const MEMBER_NAMES = ['GRAND-PERE', 'GRAND-MERE', 'PAPA', 'MAMAN', 'FILS', 'FILLE', 'CHIEN'];
    public const LINK_IMAGE = "https://www.placecage.com/640/360";
    private const DIR_UPLOAD = '/uploads/members/';
// @codingStandardsIgnoreEnd
    public function load(ObjectManager $manager)
    {
        for ($key = 0; $key < count(CommandFixtures::COMMANDS); $key++) {
            foreach (self::MEMBER_NAMES as $keyMember => $memberName) {
                $member = new Member();
                $member->setCommand($this->getReference('projet_' . $key));
                $member->setName($memberName);
                $member->setCardNumber($keyMember + 1);
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
        return [
          CommandFixtures::class,
        ];
    }
}
