<?php

namespace App\Service;

use Symfony\Component\String\Exception\InvalidArgumentException;

class GameCard
{
    public const GAME_MIN = 10;
    public const GAME_MAX = 20;
    public const PRICE_MAX = 34.99;
    public const PRICE_MIN = 24.99;

    public function priceGame(int $cars): ?float
    {
        $price = '';
        if ($cars <= self::GAME_MIN) {
            $price = self::PRICE_MIN;
        } elseif ($cars <= self::GAME_MAX) {
            $price = self::PRICE_MAX;
        } else {
            throw new InvalidArgumentException(sprintf(" trop de membres"));
        }
        return $price;
    }
}
