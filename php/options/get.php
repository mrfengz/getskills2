<?php
echo 'get_current_user() '.get_current_user(),PHP_EOL;

echo 'getmygid() 获取当前脚本的group id: '.getmygid().PHP_EOL;
echo 'getmyuid() 获取当前脚本的user id: '.getmyuid().PHP_EOL;
echo 'getmypid() 获取当前脚本的process id: '.getmypid().PHP_EOL;

echo 'get_included_files() '. PHP_EOL;
    print_r(get_included_files());

echo "getenv()[like '$_ENV'] : ". getenv('REMOTE_ADDR'),PHP_EOL;

echo "getlastmod() 获取当前脚本最后修改时间(filemtime): ".getlastmod(),PHP_EOL;


//getopt($options, $longopts)
// $options 匹配 -参数
//      字符  不接受值
//      :   此选项接收值
//      ::  此选项参数可选

// php get.php -f[=]123 -hddd
$options = getopt('f:hp:');
print_r($options);
// Array
// (
//     [f] => 123
//     [h] =>
// )

echo 'php_uname(): ',PHP_EOL;
print_r(php_uname());


$fp = tmpfile();
print_r(get_resources());

//获取资源使用情况
$dat = getrusage();
var_export($dat);
/*
array (
    'ru_oublock' => 14,
    'ru_inblock' => 15,
    'ru_msgsnd' => 213,
    'ru_msgrcv' => 389,
    'ru_maxrss' => 25845760,
    'ru_ixrss' => 0,
    'ru_idrss' => 0,
    'ru_minflt' => 12946,
    'ru_majflt' => 516,     #num of page faults
    'ru_nsignals' => 0,
    'ru_nvcsw' => 489,
    'ru_nivcsw' => 4392,
    'ru_nswap' => 0,        #num of swaps
    'ru_utime.tv_usec' => 921114,   #user time used seconds
    'ru_utime.tv_sec' => 0,         # user time used microseconds
    'ru_stime.tv_usec' => 160415,
    'ru_stime.tv_sec' => 0,
);

*/
