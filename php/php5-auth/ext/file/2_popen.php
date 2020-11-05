<?php
/**
 * 想处理一个程序的输入和输出时，为那个程序打开一个流。需要两个通道，一个读取，一个写入
 * popen()      提供一个单向的IO，可以使用w或者r作为模式。 然后使用常规的文件函数从该管道中读取或写入。
 *
 * proc_open(string cmd, array desc, array pipes)  popen不提供与打开的进程交互的功能。proc_open提供
 *      cmd     执行的命令
 *      desc    一个数组，用来描述针对输入或者输出的一个文件处理器
 */


// popen()
$fp = popen("ls -l .", 'r');

while (!feof($fp)){
    echo fgets($fp);
}

pclose($fp);


// proc_open()

// 1
/*$fin = fopen("2_readfrom", "r");
$fout = fopen("2_writeto", "w");
$desc = array($fin, $fout);
$res = proc_open("php", $desc, $pipes);
if ($res){
    proc_close($res);
}*/

// 2 管道
//把php脚本代码本身从脚本本身发送到启动的php解释器，而不是通过文件处理器解决输入和输出。
$descs = [
    0 => array("pipe", 'r'),
    1 => array("pipe", "w"),
];
$res = proc_open("php", $descs, $pipes);

if (is_resource($res)) {
    fputs($pipes[0], '<?php "Hello you!\n";?>');
    fclose($pipes[0]);

    while(!feof($pipes[1])) {
        $line = fgets($pipes[1]);
        echo urlencode($line);
    }
    proc_close($res);
}

//3 把文件作为处理器传递给你的进程的文件描述符
$descs = [
    ['pipe', 'r'],
    ['file', 'output',  'w'],
    ['file', 'w']
];

$res = proc_open("php", $descs, $pipes);
if(is_resouce($res)){
    fputs($pipes[0], '<?php echo "Hello world\n";?>');
    fclose($pipes[0]);
    proc_close($res);
}
