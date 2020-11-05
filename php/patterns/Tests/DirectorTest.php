<?php
require 'Loader.php';
use DesignPatterns\Tests\Loader;
use DesignPatterns\Creational\Builder\Director;
use DesignPatterns\Creational\Builder\CarBuilder;

Loader::register();

$car = new CarBuilder();
$a = new Director;

$baoma = $a->build($car);
var_dump($baoma);