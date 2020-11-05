<?php

var_export(parse_url($url = 'http://username:password@hostname/path/index.php?arg=value#anchor'));
/*
 array (
  'scheme' => 'http',
  'host' => 'hostname',
  'user' => 'username',
  'pass' => 'password',
  'path' => '/path/index.php',
  'query' => 'arg=value',
  'fragment' => 'anchor',
)
 */

//rawurldecode() vs urldecode()  前者不会把+转化为 (空格)，后者可以
//RFC 3896 rawurlencode/decode()  除了 ~. -_之外的其他非字母、数字的字符都会被替换成%something

//urldecode()解码给出的字符串中的任何%##, + 会被转换为一个空格字符 $_GET和$_REQUEST已被解码


print_r(get_meta_tags('http://houtai.rebuy.com.cn/admin/index.php/home'));

print_r(get_headers('http://houtai.rebuy.com.cn/admin/index.php/home'));

echo $enc = base64_encode('this is something for test.');

echo $dec = base64_decode($enc);

