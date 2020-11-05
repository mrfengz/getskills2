<?php
namespace DesignPatterns\Creational\Factory;

abstract class FactoryMethod
{
    const CHEAP = 'cheat';
    const FAST = 'fast';

    //需要在具体类中实现的方法
    abstract protected function createVehicle(string $type) :VehicleInterface;

    /**
     * 执行创建工厂的方法
     * @param string $type
     * @return VehicleInterface
     */
    public function create(string $type):VehicleInterface
    {
        $obj = $this->createVehicle($type);
        $obj->setColor('black');

        return $obj;
    }
}