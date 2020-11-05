<?php
include "retwis.php";
include "header.php";

$r = redisLink();

if (!gt('u') or !($userid = $r->hget("users", gt('u')))) {
    header("Location: index.php");
    exit(1);
}
//点击用户详情后，可以关注或取关
echo ("<h2 class=\"username\"" . utf8entities(gt('u')))."</h2>";
if (isLoggedIn() && $user['id'] != $userid) {
    //判断是否关注
    $isFollowing = $r->zscore("following:".$user['id'], $userid);
    if (!$isFollowing) {
        echo("<a href=\"follow.php?uid=$userid&f=1\" class=\"button\">Follow this user</a>");
    } else {
        echo("<a href=\"follow.php?uid=$userid&f=0\" class=\"button\">Stop following</a>");
    }
}
?>
<?
$start = gt("start") === false ? 0 : intval(gt("start"));
showUserPostsWithPagination(gt("u"),$userid,$start,10);
include("footer.php")
?>
