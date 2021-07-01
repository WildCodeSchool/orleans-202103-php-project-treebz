<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Theme;
use Faker\Factory;
use DateTime;

class ThemeFixtures extends Fixture
{
    public const LINK_IMAGES = 'public/build/canva_png/';
    public const THEMES = [
        [
            'name' => 'Cuisine',
            'colorText' => '#FFFFFF',
        ],
        [
            'name' => 'Ecolo',
            'colorText' => '#FFFFFF',

        ],
        [
            'name' => 'Voyage',
            'colorText' => '#FFFFFF',

        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::THEMES as $key => $themeData) {
            $theme = new Theme();
            $this->addReference('theme_' . $key, $theme);
            $theme->setName($themeData['name']);
            $theme->setColorText($themeData['colorText']);
            $theme->setUpdatedAt(new DateTime('now'));
            $urlImage = self::LINK_IMAGES . ($key + 1) . '.png';
            $path = uniqid() . '.png';
            // Function to save image URL into file
            copy($urlImage, 'public/uploads/themes/' . $path);
            $imagePath = $path;
            $theme->setImage($imagePath);
            $manager->persist($theme);
        }
        $manager->flush();
    }
}
