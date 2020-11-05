<?php
/**
 * 功能：主进程创建子进程，当主进程结束时，子进程检测到后会自动exit
 * 子进程退出时，父进程检测到后会重新创建一个进程
 */
(new Class
{
    public $mpid = 0;
    public $workers = [];
    public $max_process = 1;
    public $new_index = 0;

    public function __construct()
    {
        try {
            swoole_set_process_name(sprintf("php-ps: %s", "master"));
            $this->mpid = posix_getpid();
            $this->run();
            $this->processWait();
        } catch (\Exception $e) {
            die("All Error: " . $e->getMessage());
        }
    }

    public function run()
    {
        //创建指定数量的process
        for ($i = 0; $i < $this->max_process; $i++) {
           $this->createProcess();
        }
    }

    /**
     * 创建进程
     * @param null $index 子进程在$workers中的位置
     * @return mixed
     */
    public function createProcess($index = null)
    {
        //创建进程后回调函数
        $process = new swoole_process(function(swoole_process $worker) use ($index){
            //创建一个进程
            if (is_null($index)) {
                $index = $this->new_index;
                $this->new_index++;
            }
            swoole_set_process_name(sprintf("php-ps: %s", $index));

            //每隔1秒检测父进程是否存在，不存在就退出
            for ($j=0; $j< 10; $j++) {
                $this->checkMpid($worker);
                echo "msg: {$j}\n";
                sleep(1);
            }
        }, false, false);

        $pid = $process->start();
        $this->workers[$index] = $pid;
        return $pid;
    }

    /**
     * 检测进程并退出
     * @param $worker
     */
    public function checkMpid(&$worker)
    {
        //向pid进程发送信号 0:检测进程是否存在，不会发送信号
        //主进程不存在，就会让子进程exit()
        if(!swoole_process::kill($this->mpid, 0)) {
            $worker->exit();
            //这句话实际看不到，需要写到日志中
            file_put_contents('/tmp/sw_process.txt', "Master Process exited, I [{$worker['pid']}] alse quit\n", FILE_APPEND);
        }
    }

    /**
     * 重启进程
     * @param $ret
     * @throws Exception
     */
    public function rebootProcess($ret)
    {
        $pid = $ret['pid'];
        $index = array_search($pid, $this->workers);
        if ($index !== false) {
            $index = intval($index);
            $new_pid = $this->createProcess($index);
            echo "rebootProcess: {$index}={$new_pid} Done\n";
            return;
        }
        throw new \Exception("RebootProcess Error: no pid");
    }

    public function processWait()
    {
        while(1) {
            if(count($this->workers)) {
                //子进程退出后，回收子进程，否则子进程会变成僵尸进程，浪费操作系统资源 【阻塞等待】
                $ret = swoole_process::wait(); //返回一个包含子进程的PID，退出状态码、被哪种信号kill的数组

                //重启子进程
                if ($ret) {
                    $this->rebootProcess($ret);
                }
            } else {
                break;
            }
        }
    }
});
