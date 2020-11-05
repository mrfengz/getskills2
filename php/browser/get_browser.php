<?php
echo $_SERVER['HTTP_USER_AGENT'].PHP_EOL;

var_dump(get_browser(null, true));

//使用正则匹配不同的浏览器
if(preg_match('/i(Phone|Pad)|Android|Blackberry|Symbian|windows (ce|phone)/i', $_SERVER['HTTP_USER_AGENT'])) {
    //重定向，加载不同的模板和css
    header('Location: mobile/index.php');
}
