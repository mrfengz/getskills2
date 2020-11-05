<?php
include 'Loader.php';

use DesignPatterns\Tests\Loader;
use DesignPatterns\Creational\SimpleFactory\SimpleFactory;

Loader::register();

class SimpleFactoryTest
{
    public function testCanCreateBicycle()
    {
        $bicycle = (new SimpleFactory())->createBicycle();
        $bicycle->driveTo('阿信');
    }
}

$test = new SimpleFactoryTest();
$test->testCanCreateBicycle();