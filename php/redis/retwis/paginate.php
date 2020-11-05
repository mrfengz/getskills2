<?php
function showPost($id)
{
    $r = redisLink();
    $post = $r->hgetall("post:$id");
    if(empty($post))    return false;

    $userId = $post['user_id'];
    $username = $r->hget("user:$userId", 'username');
    $elapsed = strElasped($post['time']);
    $userLink = "<a class=\"username\" href=\"profile.php?u=".urlencode($username)."\">".utf8entities($username)."</a>";

    echo ('<div class="post">'.$userLink.' '.utf8entities($post['body'])."<br>");
    echo ('<i>posted '.$elapsed.' ago via web</i></div>');
    return true;
}

function showUserPosts($userid, $start, $count ) {
    $r = redisLink();
    $key = ($userid == -1) ? "timeline" : "posts:$userid";
    $posts = $r->lrange($key, $start, $start+$count);

    $c = 0;
    foreach($posts as $p) {
        if(showPost($p)) {
            $c++;
        }
        if ($c == $count) {
            break;
        }
    }

    return count($posts) == $count+1;
}
