<?php
function p($param)
{
    print_r($param);
    echo PHP_EOL;
}

//1. addslashes()  addcslashes()
if (!get_magic_quotes_gpc()) {
    $slashedStr = addslashes("add slash before \" ' \ NUL and so on ");
    p($slashedStr);
}

//2 bin2hex() 二进制2十六进制
p($hex = bin2hex("bin2hex"));

// 3 hex2bin() 十六进制转换为2进制
p(hex2bin($hex));

// 4.ord($char) 返回字符的ASCII值
p($asciiChar = ord('H'));

//5 chr($asciiChar) 返回ascii值对应的字符
p(chr($asciiChar));

//6 string:chunk_split($body, $chunklen[, $end="\r\n"]) 将body分割为多块
$body = "hello, this is something very easy to use. but you shit it, so u can say byebye now!";
p(chunk_split(base64_encode($body))); //转换成符合RFC 2045语意的字符串

//7. crc32() 计算一个字符串的crc32多项式，通常用于检查数据是否完整
printf("%u", crc32("32 bit system may return negative int, so we should use printf or sprintf %u"));

//8 crypt($str, $salt) 单项序列算法 $salt =>CRYPT_STD_DES CRYPT_EXT_DES CRYPT_MD5 CRYPT_BLOWFISH CRYPT_SHA256 CRYPT_SHA512 生成的盐值
p(crypt('guesswho', '$d3$'));

//9 explode()  使用''分隔符，则会返回false; 使用其他字符时，如果找不到，且使用-$limit,返回空数组
p(explode('-', 'adber', -1));

//10 htmlentities() vs html_entity_decode()
p($ent = htmlentities('<a href="#">嗨</a>'));

p(html_entity_decode($ent));


// 11 fprintf($fp,$format, $variables...)
if (!($fp = fopen('date.txt', 'w'))) {
    return ;
}

fprintf($fp, '%04d-%02d-%02d', date("Y"), date('m'), date('d'));
fclose($fp);

echo '---------------'.PHP_EOL;

//12 lcfirst ucfirst ucwords strtolower strtoupper
$ucString = 'HelloWorld';
p($lc = lcfirst($ucString));
p(ucfirst($lc));

//13 localeconv()
p(localeconv());

// 14 md5_file($file) sha1_file($file)  md5($str) sha1($str)
p(md5_file(__FILE__));
p(sha1_file(__FILE__));
p(md5('jack', false));

// 15 money_format()

function moneyFormat($amount, $locale = 'en_US') {
    setlocale(LC_MONETARY, $locale);
    return money_format('%.2n', $amount);
}

p($a = moneyFormat(154.568));
p(moneyFormat(154.568, 'it_IT'));

// 16 nl2br($str)
p(nl2br("hello \n Jack"));

// 17 parse_str($url)
p($segs = parse_url('https://cn.bing.com/search?q=creativejs&qs=n&form=QBRE&sp=-1&pq=creative&sc=8-8&sk=&cvid=C6A86D08E67E472C96F4EE9625446085'));
parse_str($segs['query'], $res);
p($res);

// 18 quotameta($str) 转义 . \ + * ? [ ^ ] (  $ )
p(quotemeta('hello\ world * ? hello'));

// 19
// print    语言结构
// printf   格式化输出一个字符串
// sprintf() 返回一个格式化字符串
// fprintf  将结果输入到一个流中
// vfprintf($formatter, $arr) 参数是数组，类似于sprintf()
// vprintf() 与printf()类似，接收的变量是数组
// vsprintf() 与sprintf()类似，接收的变量是数组
$str = sprintf("There %d monkeys in the %s", 5, 'tree');
p($str);

// $format = "There %2$s contains %1$d monkeys.";
$format = 'The %2$s contains %1$d monkeys.'; //必须是单引号，否则就jj了
//后边参数可以不按照占位符顺序来，必须是%数字$格式， [%数字]
$str = sprintf($format, $num = 5, $tree = 'tree');
p($str);

//填充前导值 %'填充
p(sprintf("%'.9d\n", 123));
p(sprintf("%'.09d\n", 123));

p(sprintf('The %2$s contains %1$04d Monkey', 5, "Lemon tree"));

// 20 sscanf($str, $format[, mixed &$...]) 类似于printf()
list($serial) =sscanf('SN/2305860', 'SN/%d');
p($serial);

$mandate = "January 01 2000";
list($month, $day, $year) = sscanf($mandate, "%s %d %d");
p($month);
p($day);
p($year);

$n = sscanf("34\tLewis Caroil", "%d\t%s %s", $id, $first, $last);
echo "n: $n, id: $id, first: $first, last: $last\n";

// 21 str_split($str, $perLength=1)
p(str_split("Hello Jack", 2));
p(str_split("你在干啥"));

// 22 strcasecmp($str, $str2) 不区分大小写的二进制比较
// strcmp($str, $str2) 不区分大小写的二进制比较
// strnatcasecmp() 不区分大小写的自然排序 // 0 10 12 2
// strnatcmp() 区分大小写的自然排序
// strncasecmp() 不区分大小写的前n位自然排序
p('-'.strcasecmp('Abc', 'ABC').'===='); //0
p('-'.strcmp('Abc', 'ABC').'====');     //32

// 23 strpos/strrpos() 查找子字符串首次/最后一次出现的位置 stripos/strripos() 不区分大小写查找字符串首次出现位置
//strrchr() 查找【字符】在字符串中首次出现的位置
//strstr($haystack,$needle) 查找从needle开始到字符串结尾的字符串
//strpbrk($haystack, $charList) 查找$charList中首次出现的字符到结尾的字符串
//substr($str, $start, $length) 返回字符串的一部分
$str = "This is a sunshine day";
p(strpbrk($str, 'im')); //is is a sunshine day

// 查找后缀
p(substr(strrchr("hellosweety.png", '.'), 1)); //png

// 24 strtok()
$string = "This is\tan example\nstring";
/* 使用制表符和换行符作为分界符 */
$tok = strtok($string, " \n\t");

while ($tok !== false) {
    echo "Word=$tok<br />";
    $tok = strtok(" \n\t");
}

// 25 strtr($str, $from, $to) strtr($str, $pairs)将字符串$str中的$from替换为$to.
//已经替换过的部分不会再次被替换
p(strtr("hi all, I said hello, hi", ['hi' => "Hello", 'hello' => 'Hi']));

p(strtr("he??]", '??]', 'llo'));

//26 substr_count() 计算字符串出现的次数 str_word_count()统计字符串中word出现的次数

// 27 substr_replace()
$input = array('A: XXX', 'B: XXX', 'C: XXX');

// A simple case: replace XXX in each string with YYY.
echo implode('; ', substr_replace($input, 'YYY', 3, 3))."\n";

// 28 wordwrap($str, $length=75, $break="\n", $cut = false)

$str = "This is a super long string, but what can we do to make it can be shown in some nitty styles to have a better impression to customer?";
$str = "今天天气不错啊，没错！今天天气不错啊，没错！今天天气不错啊，没错！今天天气不错啊，没错！今天天气不错啊，没错！今天天气不错啊，没错！今天天气不错啊，没错！今天天气不错啊，没错！";
var_dump(wordwrap($str, 75, "\n", false));
