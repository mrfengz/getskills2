<?php
//写入
while(true){
    $fp = fopen('testfile', 'w');
    echo "waiting for lock ...";
    //一个排它锁只能在文件没有其他锁时被授予。
    flock($fp, LOCK_EX);
    echo "ok\n";

    $date =date('Y-m-d H:i:s\n');
    echo $date;
    fputs($fp, $date);
    sleep(1);

    echo "Releasing lock...";
    flock($fp, LOCK_UN);
    echo "OK\n";
    fclose($fp);
    usleep(1);
}

//读取
while(true) {
    $fp = fopen('testfile', 'r');
    echo "waiting for lock ...\n";
    //如果已经有了排它锁，则无法获取获取共享锁。 无锁或者有共享锁，都可以获取锁。
    flock($fp, LOCK_SH);
    echo "OK\n";

    echo fgets($fp, 2048);

    echo "Releasing lock ...\n";
    flock($fp, LOCK_UN);
    echo "OK\n";

    fclose($fp);
    sleep(1);
}

