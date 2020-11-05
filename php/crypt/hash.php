<?php

$ext = 'blue_skirt.jpg';
var_dump(pathinfo($ext, PATHINFO_EXTENSION));die;

//hash_file() 使用给定的文件内容生成哈希值
$fileHash = hash_file('ripemd256', 'random_bytes.php');
var_dump($fileHash);

//hash_equals() 比较两个字符串是否相等，可用于防止时序攻击的字符串比较场景汇总，比如比较crypt()密码哈希值的场景
$expected  = crypt('12345', '$2a$07$usesomesillystringforsalt$');
$correct   = crypt('12345', '$2a$07$usesomesillystringforsalt$');
$incorrect = crypt('apple',  '$2a$07$usesomesillystringforsalt$');

var_dump(hash_equals($expected, $correct));
var_dump(hash_equals($expected, $incorrect));

//hash_algos() 使用的算法列表
$hash_algos = hash_algos();
print_r($hash_algos);


//hash_hmac($algo, $str, $key) 使用key加密$str
//hash_hmac_file($algo, $filename, $key)

//$ctx = hash_init($algo);
//hash_update($ctx, $update_data)
//hash_final($ctx);
