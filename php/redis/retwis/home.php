<?php
include "retwis.php";

if (!isLoggedIn()) {
    header("Location: index.php");
    exit();
}
include "header.php";
$r = redisLink();
?>

<div id="postform">
    <form action="post.php" method="POST">
        <?= utf8entities($user['username']);?>, 你是干嘛的？
        <br>

        <table>
            <tr>
                <td>
                    <textarea name="status" id="status" cols="70" rows="10"></textarea>
                </td>
            </tr>
            <tr>
                <td algin="right">
                    <input type="submit" name="doit" value="更新">
                </td>
            </tr>
        </table>
    </form>

    <div id="homeinfobox">
        <?=$r->zcard("followers:".$user['id'])?> followers<br>
        <?=$r->zcard("followering:".$user['id']);?> following <br>
    </div>
</div>

<?
$start = gt("start") === false ? 0 : intval(gt("start"));
showUserPostsWithPagination(false,$User['id'],$start,10);
include("footer.php")
?>
