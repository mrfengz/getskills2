<?php
$date = null;
var_dump(strtotime($date));die;



function test($a) {
    $a = $a * 2;
    $a = $a + 15;
    echo $a;
}
$datetime = new Datetime('now');
$datetime->add(new DateInterval('P10D'));
$date = $datetime->format(DateTime::W3C);
var_dump(test(5));
var_dump($date);die;

//获取当天的起始和结束日期
$date = (new DateTime())->format('Y-m-d');
$start = strtotime($date);
$end = $start + 86400;
var_dump([$start, $end]);
var_dump([date('Y-m-d H:i:s', $start), date('Y-m-d H:i:s', $end)]);
