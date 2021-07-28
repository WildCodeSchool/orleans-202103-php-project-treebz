<?php

namespace App\Service;

use App\Entity\Status;
use App\Entity\Command;
use Symfony\Component\Config\Definition\Exception\Exception;

class GameCard
{
    public const ZERO_MEMBRE = 0;
    public const GAME_MIN = 10;
    public const GAME_MAX = 20;
    public const PRICE_MAX = 34.99;
    public const PRICE_MIN = 24.99;

    public const PRICE_ADD_THEME = 3.99;
    public const THEMES_BEFORE_ADD_PRICE = 7;

    public const STATUS = [
        [
            'status' => 'En cours',
            'color' => 'light'
        ],
        [
            'status' => 'Commandée',
            'color' => 'danger'
        ],
        [
            'status' => 'Envoyée',
            'color' => 'primary'
        ],
        [
            'status' => 'Livrée',
            'color' => 'success'
        ],
        [
            'status' => 'Annulée',
            'color' => 'info'
        ]
    ];

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

        $themes = count($command->getSelectedThemes() ?? []);

        if ($themes > self::THEMES_BEFORE_ADD_PRICE) {
            $price = $price + (($themes - self::THEMES_BEFORE_ADD_PRICE) * self::PRICE_ADD_THEME);
        }

        return $price * $command->getQuantity();
    }

    public function statutOrdered(Command $command): bool
    {
        /** @var Status */
        $status = $command->getStatus();
        if (GameCard::STATUS[0]['status'] === $status->getName()) {
            return true;
        }
        return false;
    }
}
