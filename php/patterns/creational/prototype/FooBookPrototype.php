<?php
namespace DesignPatterns\Creational\Prototype;

class FooBookPrototype extends BookPrototype
{
    protected $category = 'foo';

    public function __clone(){}
}