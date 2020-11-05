<?php
include "retwis.php";
include "header.php";
?>
<h2>时间线</h2>
<i>最新注册用户(有序集合)</i>
<?php
showLastUsers();
?>

<i>最新的50条消息</i>
<?php
showUserPosts(-1, 0, 50);
include "footer.php";
?>
