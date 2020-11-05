<?php
/**
 * [....]   中间的内容组成一个匹配的字符类。开头使用^脱字符号表示排除使用字符类中任意的字符。
 * (...)    创建一个字正则式。
 * (?:...)  创建一个不会在正则式中获取的子表达式
 * (?P<name>...)    创建一个有名的子正则表达式
 *
 *  转义
 *  \       '/^4\*\*$/' == "/^4\\*\\*$/"(双引号中\的特殊含义)
 *  \\      '/^PHP\\\5$/'  "/^PHP\\\\5$/"   匹配'PHP\5'
 */

// 不捕获子正则式
preg_match('@([A-z ]+)(?:hans)@', "Derick Rethans", $matches);
print_r($matches);

//有名子正则式
preg_match('/(?P<century>[12][0-9])(?P<year>[0-9]{2})/', 'PHP in 2005.', $matches);
print_r($matches);

//MAC地址
$pattern = "/^$([0-9a-f]{2}:){5}[0-9a-f]{2}/";

//邮箱
//双引号中 需要使用 \\
$pattern = "/([^<]+)<([A-z0-9_-]+@([A-z0-9_-]+\\.)+[A-z]{2,4})>/";

$string = 'Derick Rethans <derick@php.net>';

preg_match($pattern, $string, $matches);
print_r($matches);

// ip
$ip = '/(\d{1,3}\.){3}\d{1,3}/';


