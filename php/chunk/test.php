<?php
require '../common.php';
/**
 * 断点续传(这个不是真正的断点下载)
 *
 * 断点续传主要是利用http协议中的Content-Range报头
 * Content-Range：响应资源的范围
 * 可以在多次请求中标记请求的资源范围，在连接断开重新连接时，客户端只请求该资源未被下载的部分
 * 迅雷就是基于这个原理，利用多线程分段读取网络上的资源，最后合并
 */

function download_briliant($file)
{
    if (!is_file($file)) {
        exit('您指定的文件不存在或者已被删除！');
    }

    $size = filesize($file);
    $size2 = $size - 1;
    $range = 0;

    //http_range表示请求一个实体/文件的一个部分,用这个实现多线程下载和断点续传！
    if (isset($_SERVER['HTTP_RANGE'])) {
        _log(__METHOD__.": HTTP_RANGE: ".$_SERVER['HTTP_RANGE']);
        header('HTTP /1.1 206 Partial Content');
        $range = str_replace('=', '-', $_SERVER['HTTP_RANGE']);
        $range = explode('-', $range);
        $range = trim($range[1]);

        header('Content-Length: '. $size);
        header('Content-Range: bytes '.$range . '-' . $size2 / $size);
    } else {
        header('Content-Length: '. $size);
        header('Content-Range: bytes 0-'.$size2 . '/' . $size);
    }

    header('Content-Type: video/mp4');
    header('Accept-Ranges: bytes');
    header('application/octet-stream');
    header('Cache-Control: public');
    header('Pragma: public');

    //解决在IE下载时中文乱码的问题
    $ua = $_SERVER['HTTP_USER_AGENT'];
    if (preg_match('/MSIE/', $ua)) {
        $ie_filename = str_replace('+', '%20', unlencode($file));
        header('Content-Disposition: attachment; filename='.$ie_filename);
    } else {
        header('Content-Disposition: attachment; filename='.$file);
    }

    $fp = fopen($file, 'rb+');
    fseek($fp, $range);
    while(!feof($fp)) {
        set_time_limit(3600 * 6);
        print_r(fread($fp, 1024));
        ob_flush();
        flush();
    }
    fclose($fp);
}

// 普通下载
function downFile($sFilePath, $downname = '')
{
    if (file_exists($sFilePath)) {
        $aFilePath = explode("/", str_replace("\\", "/", $sFilePath));
        $sFileName = $downname ?: $aFilePath[count($aFilePath) - 1];
        $nFileSize = filesize($sFilePath);
        header("Content-Disposition: attachment; filename=" . $sFileName);
        header("Content-Length: " . $nFileSize);
        header("Content-type: application/octet-stream");
        readfile($sFilePath);
    } else {
        echo("文件不存在!");
    }
}

/**
 * curl 下载
 * @param $url 下载地址
 * @param $saveFile 保存到指定文件
 * @param int $offset 偏移量
 * @param string $proxy
 * @return mixed
 */
function downUrl($url, $saveFile, $offset = 0, $proxy = '') {
    $h_curl = curl_init();
    $h_file = fopen($saveFile, 'ab');
    curl_setopt($h_curl, CURLOPT_HEADER, 0);
    curl_setopt($h_curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($h_curl, CURLOPT_TIMEOUT, 10000);
    curl_setopt($h_curl, CURLOPT_URL, $url);
    curl_setopt($h_curl, CURLOPT_FILE, $h_file);
    curl_setopt($h_curl, CURLOPT_PROXY, $proxy);//HTTP 代理通道。
    curl_setopt($h_curl, CURLOPT_SSL_VERIFYPEER, false); // 阻止对证书的合法性的检查
    curl_setopt($h_curl, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
    curl_setopt($h_curl, CURLOPT_RESUME_FROM, $offset);
    //curl_setopt($h_curl, CURLOPT_RETURNTRANSFER, true);
    $curl_success = curl_exec($h_curl);
    fclose($h_file);
    curl_close($h_curl);
    return $curl_success;
}

$file = UPLOAD_PATH. 'ci_tutorial.mp4';
// download_briliant($file);
// downFile($file, 'secret.mp4');

