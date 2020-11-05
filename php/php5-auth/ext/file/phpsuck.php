#!/usr/local/bin/php

<?php

//检查参数
if($argc < 2) {
    echo "Usage:\n phpsuck.php url [max kb/sec]\n\n";
    exit(-1);
}

//获取url
$url = $argv[1];

//带宽限制
if($argc == 3) {
    $max_kb_sec = $argv[2];
} else {
    $max_kb_sec = 1000;
}

//指向xterms的第一列
$term_sol = "\x1b[1G";
$severity_map = [
    0 => 'info',
    1 => 'warning',
    2 => 'error'
];

//指向流事件的回调
function notifier($code, $severity, $msg, $xcode, $sofar, $max)
{
    global $term_sol, $severity_map, $max_kb_sec, $size;

    //当接收到 PROGRESS 事件时，不打印状态信息前缀
    if($code != STREAM_NOTIFY_PROGRESS) {
        echo $severity_map[$severity] . ': ';
    }
    switch($code) {
        case STREAM_NOTIFY_CONNECT:
            printf("Connected\n");
            //为 kb/sec计算设置开始时间
            $GLOBALS['begin_time'] = time() - 0.001;
            break;
        case STREAM_NOTIFY_AUTH_REQUIRED:
            printf("Authentication required: %s \n", trim($msg));
            break;
        case STREAM_NOTIFY_AUTH_RESULT:
            printf("Logged in: %s\n", trim($msg));
            break;
        case STREAM_NOTIFY_MIME_TYPE_IS:
            printf("Mime type is: %s\n", trim($msg));
            break;
        case STREAM_NOTIFY_FILE_SIZE_IS:
            printf("Downloading %d kb\n", $max / 1024);
            //设置全局的宽度变量
            $size = $max;
            break;
        case STREAM_NOTIFY_REDIRECTED:
            printf("Redirecting to %s ...\n", $msg);
            break;
        case STREAM_NOTIFY_PROGRESS:
            //计算星星标记和条纹的个数
            if($size) {
                $stars = str_repeat('*', $c = $sofar * 50 / $size);
            } else {
                $stars = '';
            }

            $stripe = str_repeat('-', 50 - strlen($stars));

            //用 kb/sec的单位计算其下载速度
            $kb_sec = ($sofar / (time() - $GLOBALS['begin_time'])) / 1024;

            //如果下载速度超过了最高的输出速度的话，停止脚本
            while($kb_sec > $max_kb_sec) {
                usleep(1);
                $kb_sec = ($sofar / (time() - $GLOBALS['begin_time'])) / 1024;
            }

            //显示进度条
            printf("{$term_sol}{%s} %d kb %.1f kb/sec", $stars.$stripe. $sofar/1024, $kb_sec);
            break;
        case STREAM_NOTIFY_FAILURE:
            printf("Failure: %s\n", $msg);
            break;
    }
}

//同时确定保存的文件名
$url_data = parse_url($argv[1]);
$file = basename($url_data['path']);
if (empty($file)){
    $file = "index.html";
}

printf("Saving to $file.gz\n");
$fi1 = "compress.zlib://$file.gz";

//创建上下文并设置notifier的回调函数
$context = stream_context_create();
stream_context_set_params($context, array('notification' => 'notifier'));

//打开目标
$fp = fopen($url, 'rb', false, $context);
if(is_resource($fp)) {
    //打开本地文件
    $fs = fopen($fi1, "wb9", false, $context);
    if (is_resource($fs)) {
        //从url中以每块1024字节读取数据
        while(!feof($fp)) {
            $data = fgets($fp, 1024);
            fwrite($fs, $data);
        }
        //关闭本地文件
        fclose($fs);
    }

    fclose($fp);

    //显示下载信息
    printf("{$term_sol}{%s} Download time: %ds\n",
        str_repeat('*', 50), time() - $GLOBALS['begin_time']);
}
