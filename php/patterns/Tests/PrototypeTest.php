<?php
include 'Loader.php';

use DesignPatterns\Tests\Loader;
use DesignPatterns\Creational\Prototype\FooBookPrototype;
use DesignPatterns\Creational\Prototype\BarBookPrototype;

Loader::register();

class PrototypeTest
{
    public function testCanGetBook()
    {
        $fooPrototype = new FooBookPrototype();
        $barPrototype = new BarBookPrototype();

        for($i = 0; $i<10; $i++) {
            $book = clone $fooPrototype;
            $book->setTitle("Foo Book No". $i);
            var_dump($book instanceof FooBookPrototype);
        }


        for($i = 0; $i < 10; $i++) {
            $book = clone $barPrototype;
            $book->setTitle("Bar Book NO". $i);
            var_dump($book instanceof BarBookPrototype);
        }
    }
}

$test = new PrototypeTest();

$test->testCanGetBook();