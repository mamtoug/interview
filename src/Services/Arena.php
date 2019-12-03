<?php


namespace App\Services;


use App\Entity\AbstractHuman;

class Arena
{
    public function __construct()
    {
    }

    public function fight(AbstractHuman $firstFighter, AbstractHuman $secondFighter): int
    {
        if ($firstFighter->calculatePowerLevel() > $secondFighter->calculatePowerLevel()) {
            return 1;
        }
        if ($firstFighter->calculatePowerLevel() < $secondFighter->calculatePowerLevel()) {
            return -1;
        }
        return 0;
    }
}