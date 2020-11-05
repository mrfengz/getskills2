<?php
namespace DesignPatterns\Creational\Prototype;

class BarBookPrototype extends BookPrototype
{
    protected $category = 'bar';

    public function __clone(){}
}