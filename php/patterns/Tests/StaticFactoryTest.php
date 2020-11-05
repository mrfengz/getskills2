<?php
include 'Loader.php';

use DesignPatterns\Tests\Loader;
use DesignPatterns\Creational\StaticFactory\StaticFactory;
use DesignPatterns\Creational\StaticFactory\FormatterNumber;
use DesignPatterns\Creational\StaticFactory\FormatterString;

Loader::register();

class StaticFactoryTest
{
    public function testCanCreateNumberFormatter()
    {
        var_dump((StaticFactory::factory('number')) instanceof FormatterNumber);
    }

    public function testCanCreateStringFormatter()
    {
        var_dump(StaticFactory::factory('string') instanceof FormatterString);
    }
}

$test = new StaticFactoryTest();

$test->testCanCreateNumberFormatter();
$test->testCanCreateStringFormatter();