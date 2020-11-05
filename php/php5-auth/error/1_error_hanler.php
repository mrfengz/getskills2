<?php
/**
 * 可以发送短信，发送邮件通知，记录错误到数据库等
 * @param $errno
 * @param $errstr
 * @param $file
 * @param $line
 * @author fz
 * @time   2018/11/10 上午10:54
 */
function my_error_handler($errno, $errstr, $file, $line)
{
    if ($errno == E_NOTICE || $errno == E_USER_NOTICE) {
        error_log("$file: $line $errno: $errstr\n", 3, "/var/log/httpd/my-php-errors.log");
        return;
    }
}

/**
 * 抑制错误  @。 暂时把error_reporting()设置为0
 * 自定义的错误处理器函数可以无视操作抑制符仍然被调用。只有内置的错误显示和日志系统才会被影响。
 */
function my_error_handler2($num, $str, $file, $line)
{
    if (error_reporting() == 0) {
        print "Silent\n";
        return;
    }
    switch ($num) {
        case E_WARNING:case E_USER_WARNING:
            $type = "Warning";
            break;
        case E_NOTICE;case E_USER_NOTICE:
            $type = 'Notice';
            break;
        default:
            $type = 'Error';
            break;
    }
    $file = basename($file);
    print "$type: $file: $line $str\n";
}

set_error_handler('my_error_handler2');

trigger_error("not slient error", E_USER_NOTICE);
@trigger_error("silent error", E_USER_NOTICE);
