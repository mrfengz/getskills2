<?php
include 'Loader.php';
use DesignPatterns\Tests\Loader;
use DesignPatterns\Creational\Pool\WorkerPool;
use DesignPatterns\Creational\Pool\StringReverseWorker;

Loader::register();

class PoolTest
{
    public function testCanGetInstancesWithGet()
    {
        $pool = new WorkerPool();
        $worker1 = $pool->get();
        $worker2 = $pool->get();

        var_dump($pool->count(), 2);
    }

    public function testCanGetSameInstanceTwiceWhenDisposingFirst()
    {
        $pool = new WorkerPool();
        $worker1 = $pool->get();
        $pool->dispose($worker1);
        $worker2 = $pool->get();
        var_dump($pool->count(), 1);
        var_dump($worker1 === $worker2); //true
    }
}

$pool = new PoolTest();

$pool->testCanGetInstancesWithGet();
$pool->testCanGetSameInstanceTwiceWhenDisposingFirst();