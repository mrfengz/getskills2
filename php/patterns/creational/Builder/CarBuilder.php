<?php
namespace DesignPatterns\Creational\Builder;

use DesignPatterns\Creational\Builder\Parts\Vehicle;

class CarBuilder implements BuilderInterface
{
    /**
     * @var Parts\Car;
     */
    private $car;

    public function createVehicle()
    {
        // TODO: Implement createVehicle() method.
        $this->car = new Parts\Car();
    }

    public function addDoors()
    {
        $this->car->setPart('rightDoor', new Parts\Door());
        $this->car->setPart('leftDoor', new Parts\Door());
        $this->car->setPart('trunkLid', new Parts\Door());
    }

    public function addEngine()
    {
        // TODO: Implement addEngine() method.
        $this->car->setPart('engine', new Parts\Engine());
    }

    public function addWheel()
    {
        // TODO: Implement addWheel() method.
        $this->car->setPart('wheelLF', new Parts\Wheel());
        $this->car->setPart('wheelRF', new Parts\Wheel());
        $this->car->setPart('wheelLR', new Parts\Wheel());
        $this->car->setPart('wheelRR', new Parts\Wheel());
    }

    public function getVehicle(): Vehicle
    {
        return $this->car;
    }

}
