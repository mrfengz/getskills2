<?php

/**
 * 利用swoole的文件锁，实现锁机制。
 * Class swooleLock
 */
class swooleLock
{
    private $_handler;
    public function __construct()
    {
        $this->_handler = new swoole_lock(SWOOLE_FILELOCK, '/tmp/swf_lock.txt');
    }

    /**
     * 阻塞获取锁
     * @return mixed
     */
    public function lock()
    {
        return $this->_handler->lock();
    }

    /**
     * 释放锁
     * @return mixed
     */
    public function unlock()
    {
        return $this->_handler->unlock();
    }

    /**
     * 不阻塞锁
     * @return mixed
     */
    public function tryLock()
    {
        return $this->_handler->trylock();
    }
}

$swLock = new swooleLock();

$date = date('Y-m-d H:i:s');

//if ($swLock->lock()){ //阻塞等待锁

//不阻塞
if ($swLock->tryLock()) {
    file_put_contents("/tmp/swoole_lock.txt", $date . "获取锁\t", FILE_APPEND);
    sleep(2);
    $swLock->unlock();
    file_put_contents("/tmp/swoole_lock.txt", $date . "释放锁\n", FILE_APPEND);
} else {
    file_put_contents("/tmp/swoole_lock.txt", $date . "未获取锁\n", FILE_APPEND);
}

