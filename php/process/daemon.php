<?php

/**
 * nohup php daemon.php & 
 * nohup: 忽略exit或者控制终端正常退出。如果终端异常退出或者终止，该进程也会被关闭。输出内容会被保存到nohup.out中
 * &：程序后台运行（不会在终端输出内容），关闭终端，程序会退出
 *
 * 该程序直接关闭终端后，新开终端查看进程仍然存在。
 */


/**
 * 实现守护进程步骤
 * 1.fork子进程，父进程退出（当前子进程会成为init进程的子进程）
 * 2.子进程调用setsid(),开启一个新会话，成为新的会话组长，并且释放与终端的关联关系
 * 3.再次fork子进程，父进程退出（可以防止会话组长重新申请打开终端）
 * 4.关闭打开的文件描述符
 * 5. 改变当前工作目录 chdir(此步骤非必须)
 * 6. 清除进程的umask
 */

//fork一次，子进程才可以调用setsid(),父进程(进程组leader不能调用setsid())
$pid = pcntl_fork();
if ($pid < 0) {
	exit('fork error.');
} else if($pid) {
	exit('parent process exit.');
}

// 子进程提升为会话组组长 
if(!posix_setsid()) {
	exit(' set sid error.');
}

// 二次fork
$pid = pcntl_fork();
if ($pid < 0) {
	exit('fork error.');
} else if($pid) {
	exit('parent process exit.');
}

// 关闭各种描述符
@fclose(STDOUT);
@fclose(STDERR);
$STDOUT = fopen('/dev/null', 'a');
$STDERR = fopen('/dev/null', 'a');

chdir('/');

umask(0);


//后台运行的代码
for($i = 0; $i <= 100; $i++) {
	sleep(1);
	file_put_contents('daemon.log', $i . PHP_EOL, FILE_APPEND);
}


