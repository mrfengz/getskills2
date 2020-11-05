<?php
namespace DesignPatterns\Creational\Builder;

use DesignPatterns\Creational\Builder\Parts\Vehicle;

/**
 * 建造一个交通工具需要的共同步骤
 * Interface BuilderInterface
 * @package DesignPatterns\Creational\Builder
 */
interface BuilderInterface
{
    public function createVehicle();

    public function addWheel();

    public function addEngine();

    public function addDoors();

    public function getVehicle():Vehicle;
}
