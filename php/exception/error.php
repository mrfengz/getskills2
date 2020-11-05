<?php
//var_dump(error_reporting());// 32767
//var_dump(E_NOTICE, E_ALL & E_NOTICE); //8 8


error_reporting(-1);
//ini_set('display_errors', 0);
set_error_handler('error_handler');
register_shutdown_function('shutdown');
echo $a;
$b / 0;
fund();


function error_handler($errno, $error, $errline, $errfile){
    var_dump($errno, $error, $errline, $errfile);
}
function shutdown() {
    var_dump(error_get_last());
}