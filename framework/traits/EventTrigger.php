<?php
namespace Kolt\Traits;

trait EventTrait
{
    protected $events = [];

    /**
     * 注册事件监听
     * @param $event    事件名称
     * @param $callback 回调
     * @param bool $first 是否优先执行(插入对列头部)
     * @param bool $once  是否只执行一次
     */
    public function register($event, $callback, $first = false, $once = false)
    {
        if(!isset($this->events[$event])){
            $this->events[$event] = [];
        }

        $item = [
            'callback' => $callback,
            'once' => $once,
        ];

        if ($first) {
            array_unshift($this->events[$event], $item);
        } else {
            $this->events[$event][] = $event;
        }
    }

    /**
     * 注册一次性事件
     * @param $event
     * @param $callback
     * @param bool $first
     */
    public function once($event, $callback, $first = false) {
        $this->register($event, $callback, $first, true);
    }

    protected function trigger($event, $params)
    {
        if(!isset($this->events[$event])) {
            return error_log("事件{$event}未注册\n");
        }

        foreach($this->events[$event] as $key => $item) {
            if (true == $item['once']) {
                //很奇怪这个没有执行就直接删除了
                unset($this->events[$event][$key]);
            }

            if(true == call_user_func_array($item['callback'], $params))
            {
                //事件返回true,不继续执行其余事件， 注册多个事件是否有意义
                return true;
            }
        }

        return false;
    }
}