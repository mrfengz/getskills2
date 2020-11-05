<?php
namespace DesignPatterns\Creational\Pool;

class WorkerPool implements \Countable
{
    /**
     * @var array 使用中的workers
     */
    private $occupiedWorkers = [];

    /**
     * @var array 空闲的workers
     */
    private $freeworkers = [];

    public function get():StringReverseWorker
    {
        if (count($this->freeworkers) == 0) {
            $worker = new StringReverseWorker();
        } else {
            $worker = array_pop($this->freeworkers);
        }

        $this->occupiedWorkers[spl_object_hash($worker)] = $worker;

        return $worker;
    }


    /**
     * 强制释出运行中的某个worker
     * @param StringReverseWorker $worker
     */
    public function dispose(StringReverseWorker $worker)
    {
        $key = spl_object_hash($worker);
        if (isset($this->occupiedWorkers[$key])) {
            unset($this->occupiedWorkers[$key]);
            $this->freeworkers[$key] = $worker;
        }
    }

    public function count():int
    {
        return count($this->occupiedWorkers) + count($this->freeworkers);
    }
}