<?php
namespace DesignPatterns\Creational\SimpleFactory;

class Bicycle
{
    public function driveTo(string $destination)
    {
        echo $destination.", that's where I'm going to ...";
    }
}

/*
 * usage
 *
 * $factory = new SimpleFactory();
 * $bicycle = $factory->createBicycle();
 * $bicycle->driveTo('阿莉');
 */