<?php
//以下级别的错误不能由用户定义的函数来处理： E_ERROR、 E_PARSE、 E_CORE_ERROR、 E_CORE_WARNING、 E_COMPILE_ERROR、 E_COMPILE_WARNING，和在 调用 set_error_handler() 函数所在文件中产生的大多数 E_STRICT。

// error_reporting(E_ERROR|E_USER_ERROR);
ini_set("display_errors", 1);
//error_types 会绕过php标准错误处理，除非回调函数返回了false。  error_reporting()函数不会起到作用
set_error_handler('error_handler');
set_exception_handler('exception_handler');

function exception_handler($e)
{
    echo get_class($e).' 错误信息'.$e->getMessage().' [full info]:'.$e->getTraceAsString();
}


function error_handler($errno, $errstr, $errfile, $errline, $errcontent=[]){
    if (!(error_reporting() & $errno)) {  //不在error_reporting()中，交给系统标准的错误处理函数进行处理
        // This error code is not included in error_reporting, so let it fall
        // through to the standard PHP error handler
        return false;
    }

    //使用errorException进行处理
    throw new ErrorException($errstr, $code = 1, $errno);

    switch ($errno) {
        case E_USER_ERROR:
            echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
            echo "  Fatal error on line $errline in file $errfile";
            echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
            echo "Aborting...<br />\n";
            exit(1);
            break;

        case E_USER_WARNING:
            echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
            break;

        case E_USER_NOTICE:
            echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
            break;

        default:
            echo "Unknown error type: [$errno] $errstr<br />\n";
            break;
    }

    /* Don't execute PHP internal error handler */
    return true;
}
// var_dump(error_reporting() & E_NOTICE);
trigger_error('严重问题', E_USER_NOTICE);
