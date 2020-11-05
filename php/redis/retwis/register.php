<?php
include "retwis.php";

if (!gt('username') or !gt("password") or !gt('password2'))
    goback("用户名和密码必须填写");
if (gt('password') != gt('password2'))
    goback("两次输入的密码不一致");

$username = gt('username');
$password = gt('password');
$r = redisLink();
//users 用户名->id
if($r->hget("users", $username))
    goback("Sorry, 该用户名已被使用");
//key value 存储用户id
$userid = $r->incr("next_user_id");
$authsecret = getrand();
//注册用户新增 用户名->用户id
$r->hset("users", $username, $userid);
//hash user:$userid -> ... 存储用户信息
$r->hmset("user:$userid",
    "username", $username,
    "password", $password,
    "auth", $authsecret);
//hash auths->userid 存储用户的authsecret，类似于token，根据token换取用户信息
$r->hset("auths", $authsecret, $userid);

//zset 用户注册时间作为权重，存储用户名 按时间排序
$r->zadd("users_by_time", time(), $username);

setcookie("auth", $authsecret, time() + 3600 * 24 * 365);

include "header.php";
?>

<h2>Welcome aboard!</h2>
Hey <?=utf8entities($username)?>, now you have an account, <a href="index.php">a good start is to write your first message!</a>.
<?
include("footer.php")
?>
