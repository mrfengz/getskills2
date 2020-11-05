<?php
namespace Kolt\Libs;
include '../traits/EventTrigger.php';
use Kolt\Traits\EventTrait;

class EventFactory
{
    use EventTrait {trigger as public __trigger;}

    private static $instance;

    private function __construct(){}

    /**
     * 获取单例对象
     * @return mixed
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    public function trigger($event, $params)
    {
        return call_user_func_array([$this, '__trigger'], func_get_args());
    }
}