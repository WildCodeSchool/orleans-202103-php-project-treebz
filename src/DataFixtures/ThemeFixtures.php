<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Theme;
use Faker\Factory;
use DateTime;

class ThemeFixtures extends Fixture
{
    public const LINK_IMAGES = 'src/DataFixtures/canva_png/';
    public const THEMES = [
        [
            'name' => 'Aventure',
            'colorText' => '#FFFFFF',
        ],
        [
            'name' => 'Cuisine',
            'colorText' => '#e03a1f',

        ],
        [
            'name' => 'Ecolo',
            'colorText' => '#000000',

        ],
        [
            'name' => 'Fete',
            'colorText' => '#3e75a3',
        ],
        [
            'name' => 'Paysan',
            'colorText' => '#ad2929',
        ],
        [
            'name' => 'Ski',
            'colorText' => '#374757',

        ],
        [
            'name' => 'Sport',
            'colorText' => '#3e75a3',

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
            $urlImage = self::LINK_IMAGES . 'Famille' . $themeData['name'] . '.png';
            $path = uniqid() . '.png';
            // Function to save image URL into file
            copy($urlImage, 'public/uploads/themes/' . $path);
            $imagePath = $path;
            $theme->setImage($imagePath);
            $this->setReference('theme_' . $key, $theme);
            $manager->persist($theme);
        }
        $manager->flush();
    }
}
