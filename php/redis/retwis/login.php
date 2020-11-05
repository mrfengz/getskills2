<?php
/*
 * 用户输入用户名和密码
 * 1.根据用户名，去hash结构 username:id 查找id,不存在说明用户名不正确
 * 2.根据username:id 去hash结构查找用户信息，判断密码是否正确
 * 3.设置 authentication  hashkey:userid 作为cookie
 */

include('retwis.php');
if (!gt('username') || !gt('password')) {
    goback('你需要输入用户名和密码');
}

$username = gt('username');
$password = gt('password');
$r = redisLink();
//检查用户名是否存在
$userid = $r->hget("users", $username);
if (!$userid) {
    goback("用户名或密码错误");
}
//检查密码
$realpassword = $r->hget("user:$userid", "password");
if ($realpassword != $password) {
    goback("用户名或密码错误");
}

//设置cookie
$authsecret = $r->hget("user:$userid", "auth"); //用户创建时创建 auth
setcookie("auth", $authsecret, time() + 3600 * 24 * 365);
header("Location: index.php");

//检查用户cookie auth是否存在
function isLoggedIn()
{
    global $user;
    if (isset($user))   return true;

    if(isset($_COOKIE['auth'])) {
        $r = redisLink();
        $authcookie = $_COOKIE['auth'];
        if ($userid = $r->hgets('auths', $authcookie)) {
            if ($r->hget("user:$userid", "auth")  != $authcookie) {
                return false;
            }
            loadUserInfo($userid);
            return true;
        }
    }

    return false;
}

function loadUserInfo($userid) {
    global $user;
    $r = redisLink();
    $user['id'] = $userid;
    $user['username'] = $r->hget("user:$userid", "username");
    return true;
}
