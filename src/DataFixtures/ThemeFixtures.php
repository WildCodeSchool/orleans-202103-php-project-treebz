<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Theme;
use Faker\Factory;
use DateTime;

class ThemeFixtures extends Fixture
{

    public const THEMES = [
        [
            'name' => 'Sport',
            'colorText' => '#FFFFFF',
        ],
        [
            'name' => 'Fête Noel',
            'colorText' => '#FFFFFF',
        ],
        [
            'name' => 'Ski',
            'colorText' => '#FFFFFF',
        ],
        [
            'name' => 'Cuisine',
            'colorText' => '#FFFFFF',

        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::THEMES as $themeData) {
            $theme = new Theme();
            $theme->setName($themeData['name']);
            $theme->setColorText($themeData['colorText']);
            $theme->setUpdatedAt(new DateTime('now'));

            $urlImage = 'https://picsum.photos/seed/picsum/500/600';
            $path = uniqid() . '.jpg';

            // Function to save image URL into file
            copy($urlImage, 'public/uploads/themes/' . $path);
            $imagePath = '/uploads/themes/' . $path;
            $theme->setImage($imagePath);
            $manager->persist($theme);
        }

        $manager->flush();
    }
}
