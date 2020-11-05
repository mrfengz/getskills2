<?php
include 'Loader.php';
use DesignPatterns\Tests\Loader;
use DesignPatterns\Creational\Factory\Bicycle;
use DesignPatterns\Creational\Factory\CarFerrari;
use DesignPatterns\Creational\Factory\CarMercedes;
use DesignPatterns\Creational\Factory\VehicleInterface;
use DesignPatterns\Creational\Factory\FactoryMethod;
use DesignPatterns\Creational\Factory\GermanFactory;
use DesignPatterns\Creational\Factory\ItalianFactory;


Loader::register();

class FactoryTest
{
    public function testCanCreateCheapVehicleInGermany()
    {
        $factory = new GermanFactory();
        $result = $factory->create(FactoryMethod::CHEAP);

        var_dump($result instanceof CarMercedes);
    }

    public function testCanCreateFastVehicleInGerman()
    {
        $factory = new GermanFactory();
        $result = $factory->create(FactoryMethod::FAST);

        var_dump($result instanceof CarMercedes);
    }
}

$f = new FactoryTest;

$f->testCanCreateCheapVehicleInGermany();
$f->testCanCreateFastVehicleInGerman();