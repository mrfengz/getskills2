<?php
//ob_start();
//echo str_repeat(' ', 4096);
//ob_end_clean();
//
//ob_flush();

var_dump(ob_get_level(), ini_get('output_buffering')); // 1 4096
$file = 'ob_put.txt';
file_put_contents($file, time().' modifiy time: '."\r\n", FILE_APPEND);
$str = '';
//ob_start();
for($i = 0; $i < 30; $i++) {
    echo $str = date("Y-m-d H:i:s").str_repeat('A', 4066)." ob modifiy time: ".date('Y-m-d H:i:s',filemtime($file))."\r\n";
    if ($i % 4 == 0 or $i == 29) {
        ob_flush();
        flush();
        file_put_contents($file, $str, FILE_APPEND);
        echo '-----------------------------------------<br>';
    } else {
        file_put_contents($file, $str, FILE_APPEND);
    }

}

//ob_end_clean();


die;




//每隔1s输出$i一次，脚本超时
$i = 1;

while(true) {
    echo $i++, "\n";
    ob_flush();
    flush();
    sleep(1);
    if ($i == 200) {
        break;
    }
}