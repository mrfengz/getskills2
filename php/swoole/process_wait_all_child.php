<?php
(new class
{
    public $childProcessNum = 2;

    public function __construct()
    {
        $this->run();
        $this->wait();
    }

    public function run()
    {
        $queryNum = 1000;
        for ($i = 0; $i < $this->childProcessNum; $i++) {
            $this->createProcess($i * $queryNum);
        }
    }

    protected function createProcess($startNum)
    {
        $process = new swoole_process(function (swoole_process $worker) use ($startNum) {
            $limit = 10;
            for ($i = 0; $i < $limit; $i++) {
                echo "NO. " . ($startNum + $i) . PHP_EOL;
            }
            echo "sleep seconds: " . ($sleep = mt_rand(1, 4)) . PHP_EOL;
            sleep($sleep);
        });
        $process->start();
    }

    protected function wait()
    {
        $workers = [];
        /*
          Array
            (
                [0] => Array
                    (
                        [pid] => 1864
                        [code] => 0
                        [signal] => 0
                    )

                [1] => Array
                    (
                        [pid] => 1865
                        [code] => 0
                        [signal] => 0
                    )

            )

         */
        while (1) {
            $workers[] = swoole_process::wait();
            if (count($workers) == $this->childProcessNum) {
                echo "all Child Process run finished\n";
                print_r($workers);
            }
        }
    }
});
