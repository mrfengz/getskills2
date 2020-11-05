<?php
include ('retwis.php');

if (!isLoggedIn() || !gt('status')) {
    header("Location: index.php");
    exit();
}

$r = redisLink();
$postid = $r->incr('next_post_id');
$status = str_replace("\n", " ", gt('status'));
//插入记录
$r->hmset("post: $postid", "user_id", $user['id'], "time", time(), "body", $status);
//获取所有关注者， 这是一个集合
$followers = $r->zrange("followers: {$user['id']}", 0, -1);

//将新增的id推送给关注的人 posts:followingId
$followers[] = $user['id'];
foreach($followers as $fid) {
    $r->lpush("posts: $fid", $postid);
}
//把post添加到时间轨迹中, 同时保持长度为1000个。显示最新的1000个所有人的post
$r->lpush("timeline", $postid);
$r->ltrim("timeline", 0, 1000); //删除超过长度的

header("Location: index.php");


