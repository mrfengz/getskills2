<?php
//preg_match_all
/*$raw_document = file_get_contents('http://www.w3.org/TR/CSS21');
$doc = html_entity_decode($raw_document);
$count = preg_match_all(
    '/<(?P<email>([a-z.]+).?@[a-z0-9]+\.[a-z]{1-6})>/Ui',
    $doc,
    $matches
);

var_dump($matches);*/

//preg_grep 返回一个与正则式匹配的元素
$address = array(
    '212.187.38.47',
    '188.141.21.91',
    '2.9.256.7'
);
$pattern = '@^((\d?\d|1\d\d|2[0-4]\d|25[0-5])\.){3}'.
    '(\d?\d|1\d\d|2[0-4]\d|25[0-5])$@';

$replacement = '<a href="\\1">\\2</a>';
//返回一个匹配成功的元素
$addresses = preg_grep($pattern, $address);
print_r($addresses);

//preg_replace() 替换函数
$str = '[link url="http://php.net"]PHP[/link] is cool.';

$pattern = '@\[link\ url="([^"]+)"\](.*?)\[/link\]@';
// 匹配的元素整体为 0， 每个子正则表达式 为1 2 。。。
// 可以使用\\1 或者 $1. 最好把替换后的结果放到''号中，否则就是 \\\\1 和 \$2这种写法
//如果为后向引用+数字 ${1}1
$replacement = '<a href="\\1">\\2</a>';
$str = preg_replace($pattern, $replacement, $str);
echo $str;

// ----------- 回调 ------------
$names = array(
    'rethans, derick',
    'saher bakken, stig',
    'gutmans, andi'
);

$names2 = preg_replace('@([^,]+).\ (.*)@', '\\2 \\1', $names);
print_r($names2);

//使用e或者preg_replace_callback()函数把第一个字母改为大写
$names3 = preg_replace('@([^,]+).\ (.*)@e', 'ucwords("\\2 \\1")', $names);
print_r($names3);

// ********* 回调2 ********
function format_string($matches)
{
    return ucwords("{$matches[2]} {$matches[1]}");
}

$names4 = preg_replace_callback(
    '@([^,]+).\ (.*)@',
    'format_string', //callback function
    $names //array with objects
);
print_r($names4);

// ********* 回调3 **********
$show_with_vat = true;
$format = '&euro; %.2f';
$exchange_rate = 1.2444;

function currency_output_vat($data)
{
    $price = $data[1];
    $vat_percent = $data[2];

    $show_vat = isset($GLOBALS['show_with_vat']) && $GLOBALS['show_with_vat'];

    $amount = ($show_vat) ? $price * (1 + $vat_percent / 100) : $price;

    return sprintf($GLOBALS['format'], $amount / $GLOBALS['exchange_rate']);
}

$data = "This item costs (amount: 27.95 %19%) ".
    "and the other one costs (amount: 29.95 %0%). \n";
echo preg_replace_callback('/\(amount\:\ \%([0-9.]+)\%)/',
    'currency_output_vat', $data);


//preg_split() 通过一个正则表达式作为定界符分割字符串为多个子字符串
$str = "Thisi is an example for preg_split().";
$words = preg_split('@[\W]+@', $str);
print_r($words);

//返回的数量
$words2 = preg_split('@[\W]+@', $str, 2);
print_r($words2);

//标志位
$words3 = preg_split('@[\W]+@', $str, -1, PREG_SPLIT_NO_EMPTY);
print_r($words3);
