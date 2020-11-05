<?php
namespace Kolt\Libs;
include './EventFactory.php';

use Kolt\Libs\EventFactory;

class Event
{
    public static function register($event, $callback, $first = false, $once = flase)
    {
        call_user_func_array([EventFactory::getInstance(), 'register']);
    }

    //register 别名
    public static function on($event, $callback, $first = false, $once = flase)
    {
        call_user_func_array([EventFactory::getInstance(), 'register']);
    }

    // once
    public static function once($event, $callback, $first = false)
    {
        call_user_func_array([EventFactory::getInstance(), 'once'], func_get_args());
    }

    // trigger
    public static function trigger($event, $params = [])
    {
        call_user_func_array([EventFactory::getInstance(), 'trigger'], func_get_args());
    }
}

