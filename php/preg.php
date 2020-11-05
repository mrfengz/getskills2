<?php

$str = 'AzdeZ';
$phone = '020-55887812-223';
$pattern = '/^(0\d{2}-)?(\d{7,8})(-\d{3,4})?$/';

$res = preg_match($pattern, $phone);
var_dump($res);