<?php

namespace App\Service;

use App\Entity\Command;
use Symfony\Component\Config\Definition\Exception\Exception;

class GameCard
{
    public const ZERO_MEMBRE = 0;
    public const GAME_MIN = 10;
    public const GAME_MAX = 20;
    public const PRICE_MAX = 34.99;
    public const PRICE_MIN = 24.99;

    public function priceGame(Command $command): float
    {

        $members = count($command->getMembers() ?? []);

        if ($members === self::ZERO_MEMBRE) {
            $price = 0;
        } elseif ($members <= self::GAME_MIN) {
            $price = self::PRICE_MIN;
        } elseif ($members <= self::GAME_MAX) {
            $price = self::PRICE_MAX;
        } else {
            throw new Exception("Trop de membres");
        }

        return $price;
    }
}
