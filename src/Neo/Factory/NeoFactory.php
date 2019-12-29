<?php


namespace App\Neo\Factory;


use App\Neo\Entity\Neo;

class NeoFactory
{
    public static function create(\DateTime $date, int $reference, string $name, string $speed, bool $isHazardous): Neo
    {
        $neo = new Neo();

        $neo->setDate($date);
        $neo->setReference($reference);
        $neo->setName($name);
        $neo->setSpeed($speed);
        $neo->setIsHazardous($isHazardous);

        return $neo;
    }
}