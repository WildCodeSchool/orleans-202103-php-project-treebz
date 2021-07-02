<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        foreach (CommandFixtures::COMMANDS as $number => $mail) {
            $user = new User();
            $user->setEmail($mail['email']);
            $user->setRoles(['ROLE_USER']);
            $user->setUserDetail($this->getReference('userDetail_' . $number));
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'user'
            ));
            $this->addReference('user_' . $number, $user);

            $manager->persist($user);
        }

        $admin = new User();
        $admin->setEmail('admin@monsite.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            'admin'
        ));
        $this->addReference('user_admin', $admin);

        $manager->persist($admin);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserDetailFixtures::class
        ];
    }
}
