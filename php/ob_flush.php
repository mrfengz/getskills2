<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/9/17
 * Time: 22:51
 */

// output_buffering=0 配置需要在配置文件中修改才生效，此时间隔1s输出一个
//output_buffering=4096 仍是等到运行完毕才输出，数据比较少，未超过设置的缓冲区大小
//for($i = 0; $i < 4; $i++){
//    echo $i, "<br>";
//    flush(); //通知底层操作系统，尽快把数据发送给客户端
//    sleep(1);
//}


//每次输出4096字节 output-buffering = 4096 间隔1s输出
for($i = 0; $i < 4; $i++){
    echo mt_rand(10, 99)."-".str_repeat('a', 4093), "<br>";
    flush(); //通知底层操作系统，尽快把数据发送给客户端
    sleep(1);
}

//ob_start() 会将php缓冲区设置的足够大，等到脚本运行完毕才输出

ob_start();
for($i = 0; $i < 4; $i++){
    echo mt_rand(10, 99)."-".str_repeat('a', 4093), "<br>";
    flush(); //无效了
    sleep(1);
}
ob_end_clean();//这个不会输出缓冲区内容
ob_end_flush();//这个会输出缓冲区内容

//ob_get_level(); 开启output_buffering后，首次调用值为1
//判断
$firstLevel = ob_get_level();
if(ob_get_level() > $firstLevel) {
    //..
    //ob_end_flush()

}




var_dump(ini_get('output_buffering'));
die;



//等待运行完毕后才会输出
ini_set('output_buffering', 1);
for($i = 0; $i < 4; $i++){
    echo $i, "<br>";
    sleep(1);
}
//var_dump(ini_get('output_buffering'));