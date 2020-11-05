<?php
namespace DesignPatterns\Creational\Factory;

class CarFerrari implements VehicleInterface
{
    private $color;

    public function setColor(string $color)
    {
        $this->color = $color;
    }
}