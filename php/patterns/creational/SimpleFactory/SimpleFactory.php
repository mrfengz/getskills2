<?php
namespace DesignPatterns\Creational\SimpleFactory;

use DesignPatterns\Creational\SimpleFactory\Bicycle;

class SimpleFactory
{
    public function createBicycle(): Bicycle
    {
        return new Bicycle;
    }
}