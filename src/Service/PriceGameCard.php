<?php

namespace App\Service;

class PriceGameCard
{

    public const GAMEMIN = 10;
    public const GAMEMAX = 20;
    public const PRICEMAX = 34.99;
    public const PRICEMIN = 24.99;

    public function priceGame(int $nbCars): ?string
    {
        $price = '';

        if ($nbCars <= self::GAMEMIN) {
            $price = self::PRICEMIN . '€';
        } elseif ($nbCars <= self::GAMEMAX) {
            $price = self::PRICEMAX . '€';
        } else {
            $price = " trop de membres";
        }
        return $price;
    }
}
