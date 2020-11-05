<?php
include('retwis.php');

if (!isLoggedIn()) {
    header("Location: index.php");
    exit();
}

$r = redisLink();
$newauthsecret = getrand();
$userid = $user['id'];
$oldauthsecret = $r->hget("user:$userid", 'auth');
//退出时重新设置authsecret，同时删除旧的oldauthsecret,否则会出现不同的secret对应同一个userid
$r->hset("user:$userid", "auth", $newauthsecret);
$r->hset("auths", $newauthsecret, $userid);
$r->hdel("auths", $oldauthsecret, $oldauthsecret);


header("Location: index.php");
