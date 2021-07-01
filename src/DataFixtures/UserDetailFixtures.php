<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\UserDetail;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserDetailFixtures extends Fixture
{
    // public const USER_DETAILS = [
    //     [
    //         'lastname' => 'Stelmach',
    //         'firstname' => 'Gersey',
    //         'address' => '1 avenue champs de mars',
    //         'postalCode' => '45000',
    //         'town' => 'Orléans',
    //         'country' => 'France',
    //         'phone' => '02 06 35 65 84',
    //     ],
    //     [
    //         'lastname' => 'Blondeau',
    //         'firstname' => 'Sylva',
    //         'address' => '1 avenue champs de mars',
    //         'postalCode' => '45000',
    //         'town' => 'Orléans',
    //         'country' => 'France',
    //         'phone' => '01 04 98 45 36',
    //     ],
    //     [
    //         'lastname' => 'Olmedo',
    //         'firstname' => 'Christian',
    //         'address' => '1 avenue champs de mars',
    //         'postalCode' => '45000',
    //         'town' => 'Orléans',
    //         'country' => 'France',
    //         'phone' => '03 45 95 67 84',
    //     ],
    //     [
    //         'lastname' => 'Lay',
    //         'firstname' => 'Valentin',
    //         'address' => '1 avenue champs de mars',
    //         'postalCode' => '45000',
    //         'town' => 'Orléans',
    //         'country' => 'France',
    //         'phone' => '07 25 35 98 84',
    //     ],
    //     [
    //         'lastname' => 'Vennier',
    //         'firstname' => 'Aurélien',
    //         'address' => '1 avenue champs de mars',
    //         'postalCode' => '45000',
    //         'town' => 'Orléans',
    //         'country' => 'France',
    //         'phone' => '06 56 45 75 45',
    //     ]
    // ];
    public function load(ObjectManager $manager)
    {
        // foreach (UserFixtures::USER as $numberUser => $user) {
        //     foreach (self::USER_DETAILS as $detail) {
        //         $userDetail = new UserDetail;
        //         $userDetail->setLastname($detail['lastname']);
        //         $userDetail->setFirstname($detail['firstname']);
        //         $userDetail->setAddress($detail['address']);
        //         $userDetail->setPostalCode($detail['postalCode']);
        //         $userDetail->setTown($detail['town']);
        //         $userDetail->setCountry($detail['country']);
        //         $userDetail->setPhone($detail['phone']);
        //         $userDetail->setUser($this->getReference('user_' . $detail));

        //         $manager->persist($userDetail);
        //         // $this->addReference('userDetail_' . $detail, $userDetail);
        //     }
        // }
        // $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}
