<?php
/**
 * 文件锁
 * 文件锁无法在多台服务器之间防止并发访问，仅可用于单台服务器的并发访问。
 *
 */
$fp = fopen('/tmp/lock.txt', 'a+');

/* flock($fp, $mode) */

//LOCK_NB 非阻塞
//LOCK_EX 独占所
//LOCK_SH 共享锁
//LOCK_UN 解除锁
if (flock($fp, LOCK_EX | LOCK_NB)) {
    //ftruncate($fp, 0);
    sleep(1);
    fwrite($fp, "write something here at " . date('Y-m-d H:i:s') . "\n");
    fflush($fp);
    flock($fp, LOCK_UN);
} else {
    echo "couldn't get the lock!";
}

fclose($fp);
