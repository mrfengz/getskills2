<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
/**
 * Redis锁
 * redis锁，可以通过设置一个过期时间，防止某个任务一直占用锁，当任务异常退出时，可能导致该锁一直无法释放，影响后续请求处理
 */

class RedisLock
{
    private $_redis;
    private $config;

    public function __construct($config = array())
    {
        $this->config = $config;
        $this->_redis = $this->connect();
    }

    public function connect()
    {
        $config = $this->config;

        try {
            $redis = new Redis();
            $redis->connect($config['host'], $config['port'], $config['timeout'], $config['reserved'], $config['retry_interval']);
            if (!empty($config['auth'])) {
                $redis->auth($config['auth']);
            }
            $redis->select($config['index'] ?? 0);

            return $redis;
        } catch(\Exception $e) {
            return null;
        }
    }

    /**
     * 加锁
     * @param $key
     * @param int $expire
     * @return bool
     */
    public function lock($key, $expire = 5)
    {
        //检查是否存在该key
        $isLock = $this->_redis->setnx($key, time() + $expire);

        //已存在key，上锁失败
        if (!$isLock) {
            $lockTime = $this->_redis->get($key);
            //锁已过期，删除并重新上锁，返回重新上锁的结果
            if ($lockTime < time()) {
                $this->unlock($key);
                $isLock = $this->_redis->setnx($key, time() + $expire);
            }
        }

        return $isLock;
    }

    /**
     * 删除锁
     * @param $key
     */
    public function unlock($key)
    {
        $this->_redis->del($key);
    }
}

$config = [
    'host' => '127.0.0.1',
    'port' => 6379,
    'index' => 0,
    'auth' => '',
    'timeout' => 1,
    'reserved' => null,
    'retry_interval' =>100
];

$redisLock = new RedisLock($config);

$lockKey = 'mylock';
$date = date('Y-m-d H:i:s');
if ($redisLock->lock($lockKey)) {
    file_put_contents('/tmp/log.txt', $date . "获取锁成功\t", FILE_APPEND) ;
    sleep(2);
    file_put_contents('/tmp/log.txt', $date . "释放锁\n", FILE_APPEND) ;
    $redisLock->unlock($lockKey);
} else {
    file_put_contents('/tmp/log.txt', $date . "request too frequently~!\n", FILE_APPEND) ;
}
