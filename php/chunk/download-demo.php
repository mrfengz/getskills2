
<?php

require('FileDownload.class.php');
$file = 'book.zip';
$name = time().'.zip';
$obj = new FileDownload();
$flag = $obj->download($file, $name);
//$flag = $obj->download($file, $name, true); // 断点续传

if(!$flag){
    echo 'file not exists';
}


// ---------------------
// 作者：傲雪星枫
// 来源：CSDN
// 原文：https://blog.csdn.net/fdipzone/article/details/9208221
// 版权声明：本文为博主原创文章，转载请附上博文链接！
