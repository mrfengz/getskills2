<?php
/**
 * 返回文件行段的内容
 * @param string $filename
 * @param int $startLine
 * @param int $endLine
 * @param string $method
 * @return string
 */
function getFileLines($filename, $startLine = 1, $endLine = 200, $method = 'rb') {
    $content = array();
    $count = $endLine - $startLine;
    // 判断php版本（因为要用到SplFileObject，PHP>=5.1.0）
    if (version_compare(PHP_VERSION, '5.1.0', '>=')) {
        $fp = new SplFileObject($filename, $method);
        // 转到第N行, seek方法参数从0开始计数
        $fp->seek($startLine - 1);
        for ($i = 0; $i <= $count; ++$i) {
            // current()获取当前行内容
            $content[] = $fp->current();
            var_dump($fp->current());
            // 下一行
            $fp->next();
        }
    } else {
        $fp = fopen($filename, $method);
        if (!$fp) {
            return 'error:can not read file';
        }
        // 跳过前$startLine行
        for ($i = 1; $i < $startLine; ++$i) {
            fgets($fp);
        }
        for ($i; $i <= $endLine; ++$i) {
            // 读取文件行内容
            $content[] = fgets($fp);
        }
        fclose($fp);
    }

    // array_filter过滤：false,null,''
    return array_filter($content);
}
 
/**
 * 返回文件的行数
 * @param string $filename
 * @return int
 */
function getFileLineCnt($filename) {
    $line = 0; //初始化行数
    //打开文件
    $fp = fopen($filename, 'rb') or die("open file failure!");
    if ($fp) {
        //获取文件的一行内容，注意：需要php5才支持该函数；
        while (stream_get_line($fp, 8192, "\n")) {
            $line++;
        }
        fclose($fp); //关闭文件
    }
    //返回行数；
    return $line;
}



// $filename = 'daemon.php';
// var_dump(getFileLineCnt($filename));
// echo '<pre>';
// var_dump(getFileLines($filename, 3, 5));