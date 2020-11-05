<?php
$arr = ['订单总金额', '1583584元'];

$length = 10;

$arr = array_pad($arr, -$length, '');

var_dump($arr);
