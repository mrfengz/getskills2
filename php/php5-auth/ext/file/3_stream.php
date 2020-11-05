<?php

/**
 * 1 输入输出流
 * 可以将stdin/stdout/stderr当做文件使用，这些文件都是链接到php进程的stdin，stdout和stderr流的
 * 通过使用一个fopen()调用的指定协议指定符来访问
 * php://
 * php://input(只读)
 * php://output
 * php://stdin（只读）
 * php://stdout
 * php://stderr
 */

echo '<pre>';
echo "Post:<br>";
print_r($_POST ?: '');

echo "php://input<br>";
$in = fopen("php://input", 'rb');
while (!feof($in)) {
    echo fread($in, 128);
}

?>
    <html>
    <form method="post" action="<?= $_SERVER['PHP_SELF']; ?>">
        <input type='text' name='example'>
        <select name='example' id=''>
            <option value='1'>第一</option>
            <option value='2'>第二</option>
        </select>
        <input type='submit'>
    </form>
    </html>

<?php

/**
 * 2 压缩流
 *  --with-zlib  compress.zlib://
 *  --with-bz2   comporess.bzip2://
 *  gzip提供比 r w a b 和 + 更多的模式指定符
 *      1-9的压缩机别，
 *      压缩方法f表示过滤
 *      h表示只是huffman压缩
 */

/**
 * 打开文件logfile.bz2文件，使用压缩机别1打开foo1.gz并写入内容。
 */
ini_set("include_path", "/var/log:/usr/var/log:.");

$url = "compress.bzip2://logfile.bz2";
$fil = "compress.zlib://foo1.gz";

$fr = fopen($url, 'rb', true);
$fw = fopen($fil, 'wb1');

if (is_resource($fr) && is_resource($fw)) {
    while(!feof($fr)){
        $data = fread($fr, 1024);
        fwrite($fw, $data);
    }
    close($fr);
    close($fw);
}


/**
 * 3 用户流
 *
 *  允许定义用户流---php代码中实现的封装流。这个用户流通过一个类来实现，针对每一个文件操作，你需要执行一个方法
 *  stream_open()
 *  stream_close()
 *  stream_read()
 *  stream_write()
 *  stream_eof()
 *  stream_tell()
 *  stream_seek()
 *  stream_flush()
 */


/**
 * 4 url流
 * url流类似于一个url的路径
 * http://  针对一个http服务器上的文件
 * https:// 针对一个使用ssl的http服务器上的文件
 * ftp://   针对一个ftp服务器上的文件
 * ftps://  ftp+ssl服务器
 *
 * --with-openssl 才可以支持ssl
 * http 或者 ftp 可以加上用户名和密码
 * 'ftp://username:password@ftp.php.net'
 *
 * http服务器支持rb，
 *
 * ftp支持 rb和wb模式，不能同时打开一个读取或者写入的流。另外尝试打开一个已经存在的文件而写入的话，连接就会失败，除非你设置overwrite选项
 */

$context = stream_context_create(
        ['ftp' => ['overwrite' => true]]
);
$fp = fopen("ftp://secret@ftp.php.net", 'wb', false, $context);

