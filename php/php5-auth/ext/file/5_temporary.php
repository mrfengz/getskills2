<?php
//创建一个文件并打开以便写入数据
$fp = tmpfile();

fwrite($fp, "temporary data");

//临时文件会在你调用fclose()时自动关闭
fclose($fp);

//控制临时文件的名字. 这个文件不会自动删除
$filename = tempnam('/tmp', 'p3pp');
$fp = fopen($filename, 'w');
fwrite($fp, "temporary data");
fclose($fp);
unlink($filename);
