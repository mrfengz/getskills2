<?php

/**
 * 获取毫秒时间戳
 * @return null|string|string[]
 * @author fz
 * @time   2018/11/12 下午5:52
 */
function getMicrotime()
{
    return preg_replace_callback('/^(.*)\s(.*)$/', function($matches){
        return $matches[1] + $matches[2];
    }, microtime());
}

echo getMicrotime();


//localtime() 返回的月份是从0开始的
print_r(localtime(time(), true));

//getdate()
print_r(getdate());

//DST时间总是比非 DST时间早一个小时

//在不同时区中显示本地时间
echo strftime("%c\n");
echo "\n EST in en_US:\n";
setlocale(LC_ALL, "en_US");
putenv('TZ=EST');
echo strftime("%c\n");

echo "\nMET in nl_NL:\n";
setlocale(LC_ALL, 'nl_NL');
putenv('TZ=MET');
echo strftime("%c\n");

echo "\nMET in no_NO:\n";
setlocale(LC_ALL, 'no_NO');
putenv('TZ=MET');
echo strftime("%c\n");

echo "\nIST in iw_IL:\n";
setlocale(LC_ALL, "iw_IL");
putenv("TZ=IST");
echo strftime("%c\n");
