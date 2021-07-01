<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public const USER = [
        '1' => 'Stelmach@treebz.com',
        '2' => 'Silva@treebz.com',
        '3' => 'Olmedo@treebz.com',
        '4' => 'Lay@treebz.com',
        '5' => 'Vennier@treebz.com'
    ];
    public function load(ObjectManager $manager)
    {
        foreach (self::USER as $number => $mail) {
            $user = new User();
            $user->setEmail($mail);
            $user->setRoles(['ROLE_USER']);
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
}
