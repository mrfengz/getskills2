<?php
namespace DesignPatterns\Creational\Builder;

use DesignPatterns\Creational\Builder\Parts\Vehicle;

/**
 * 卡车建造器
 * Class TruckBuilder
 * @package DesignPatterns\Creational\Builder
 */
class TruckBuilder implements BuilderInteface
{
    /**
     * @var Parts\Truck;
     */
    private $truck;

    public function addDoors()
    {
        $this->truck->setPart('rightDoor', new Parts\Door());
        $this->truck->setPart('leftDoor', new Parts\Door());
    }

    public function addEngine()
    {
        $this->truct->setPart('truckEngine', new Parts\Engine());
    }

    public function addWheel()
    {
        $this->truct->setPart('wheel1', new Parts\Wheel());
        $this->truct->setPart('wheel2', new Parts\Wheel());
        $this->truct->setPart('wheel3', new Parts\Wheel());
        $this->truct->setPart('wheel4', new Parts\Wheel());
        $this->truct->setPart('wheel5', new Parts\Wheel());
        $this->truct->setPart('wheel6', new Parts\Wheel());
    }

    public function createVehicle()
    {
        $this->truck = new Parts\Truck();
    }

    public function getVehicle(): Vehicle
    {
        return $this->truck;
    }
}
