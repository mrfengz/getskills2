<?php
namespace DesignPatterns\Creational\Factory;

class CarMercedes implements VehicleInterface
{
    private $color;

    public function setColor(string $color)
    {
        $this->color = $color;
    }

    public function addAMGTuning()
    {
    //    do something
    }
}