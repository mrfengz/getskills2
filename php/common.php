<?php
define('ROOT_PATH', dirname(__DIR__));
define('PHP_PATH', __DIR__);
define('LOG_PATH', ROOT_PATH.DIRECTORY_SEPARATOR . 'logs/');
define('UPLOAD_PATH', ROOT_PATH. DIRECTORY_SEPARATOR . 'uploads/');

foreach([LOG_PATH, UPLOAD_PATH] as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0770, true);
    }
}

/**
 * 记录信息到日志文件中
 * @param $str
 */
function _log($str) {
    $log_file = date('Y-m-d').'.txt';
    $fp = fopen(LOG_PATH . $log_file, 'a+') or exit('无法创建日志文件');
    fputs($fp, $str."\r\n");
    fclose($fp);
}