<?php
namespace DesignPatterns\Creational\Factory;

class Bicycle implements VehicleInterface
{
    private $color;

    public function setColor(string $rgb)
    {
        $this->color = $rgb;
    }
}