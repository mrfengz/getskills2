<?php
error_reporting(-1);
ini_set('display_errors', 1);

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

$conn = mysqli_connect('127.0.0.1', 'root', '123456', 'mytest') or exit('连接数据库失败'.mysqli_connect_error());
$conn->query("set names utf8;");
/*$res = $conn->query("show tables");
var_dump($res->fetch_all(MYSQLI_ASSOC));*/
$user_id = mt_rand(1, 99999);
$time = date('Y-m-d H:i:s');
$sql = "INSERT INTO `prizes` values(null, ?, ?, ?);";
$stmt = $conn->prepare($sql);
$sql2 = "INSERT INTO `logs` values(null, ?, ?);";

$hit = mt_rand(0, 10) > 2;

if($hit && ($prize_num = $redis->decr('redhat')) >-1){
    $stmt->bind_param('iis', $user_id, $prize_num, $time);
    $stmt->execute();
    if ($stmt->errno){
        exit('出错了'.$stmt->error);
    }

    $stmt=$conn->prepare($sql2);
    $msg = "恭喜, $user_id 中奖了";
    $stmt->bind_param('ss',$msg, $time);
    $stmt->execute();
    if ($stmt->errno){
        exit('出错了'.$stmt->error);
    }
    echo "恭喜您中奖了\n";
} else {
    $stmt=$conn->prepare($sql2);
    $msg = "sorry, $user_id 您未中奖";
    $stmt->bind_param('ss',$msg, $time);
    $stmt->execute();
    echo "抱歉，您没有中奖\n";
}
