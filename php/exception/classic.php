<?php
ini_set('display_errors', 0); //不直接展示错误

// -------- 非致命错误处理 -------
//设置一个用户的函数来处理脚本中出现的错误。
// 只能捕获系统产生的一些Warning、Notice级别的Error
//  E_ERROR、 E_PARSE、 E_CORE_ERROR、 E_CORE_WARNING、 E_COMPILE_ERROR、 E_COMPILE_WARNING，和在 调用 set_error_handler() 函数所在文件中产生的大多数 E_STRICT。
set_error_handler('error_handler');
function error_handler($errno, $errstr, $errfile, $errline) {
	$str = <<<EOF
	"errno:" . $errno
	"errstr:" . $errstr
	"errfile:" . $errfile
	"errline:" . $errline\n
EOF;
	//todo 自己处理，记录日志或者报警等 
	echo $str;
}

echo $notExists;	//notice




// -------- 异常处理 -------

// 异常处理 设置一个用户的函数来处理脚本中出现的异常。
//  php7, 致命错误也会被当做异常抛出，如果没有被捕获，则会按照以前的处理，抛出致命错误。
set_exception_handler('exception_handler');

function exception_handler($e) {
	echo "Exception caughed:" . $e->getMessage();
}

// throw new Exception("我是无敌大boss");

// -------- 致命错误处理 -------

// 程序退出时调用
/*
 * - 脚本正常退出时；
 * - 在脚本运行(run-time not parse-time)出错退出时；** parse-time出错不会触发该方法
 * - 用户调用exit方法退出时。	
 */
register_shutdown_function('app_shutdown');
function app_shutdown(){
	echo "fatal error\n";
	$error = error_get_last();
	print_r($error);
}

//  无法被set_error_handler捕获
echo test();	//fatal error;	
