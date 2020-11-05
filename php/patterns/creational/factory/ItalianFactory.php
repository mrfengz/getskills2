<?php
namespace DesignPatterns\Creational\Factory;

class ItalianFactory extends FactoryMethod
{
    protected function createVehicle(string $type): VehicleInterface
    {
        switch($type){
            case parent::CHEAP:
                return new Bicycle();
                break;
            case parent::FAST:
                return new CarFerrari();
                break;
            default:
                throw new \InvalidArgumentException("$type 非法");
        }
    }
}