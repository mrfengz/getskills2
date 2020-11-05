<?php
include 'Loader.php';

use DesignPatterns\Tests\Loader;
use DesignPatterns\Creational\Singleton\Singleton;

Loader::register();

class SingletonTest
{
    public function testUniquess()
    {
        $firstCall = Singleton::getInstance();
        $secondCall = Singleton::getInstance();

        var_dump($firstCall instanceof Singleton);
        var_dump($firstCall === $secondCall);
    }
}

$test = new SingletonTest();
$test->testUniquess();