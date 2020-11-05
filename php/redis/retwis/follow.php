<?php
include "retwis.php";

$r = redisLink();

if (!isLoggedIn() or !gt('uid') or gt('f') === false or
    !($username = $r->hget("user:".gt("uid"), "username"))) {
    header("Location:index.php");
    exit();
}

$f = intval(gt('f'));
$uid = intval(gt('uid'));

if ($uid != $user['id']) {
    if ($f) {
        $r->zadd("followers:" .$uid, time(), $user['id']);
        $r->zadd("following:".$user['id'], time(), $uid);
    } else {
        $r->zrem("followers:" .$uid, $user['id']);
        $r->zrem("following:".$user['id'], $uid);
    }
}
header("Location: profile.php?u=".urlencode($username));
