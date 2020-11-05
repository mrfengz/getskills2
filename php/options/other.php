<?php

echo 'php_uname(): ',PHP_EOL;
print_r(php_uname());


echo 'sys_get_temp_dir(): ', sys_get_temp_dir(),PHP_EOL;

//设置和获取环境变量
echo 'set env putenv():' . putenv('UNIQID: '. uniqid()),PHP_EOL;
echo 'getenv("UNIQID"): '.getenv('UNIQID'),PHP_EOL;


//获取php的版本，或者php扩展的版本
echo 'phpversion() :'.phpversion(),PHP_EOL;
echo 'phpversion("swoole"): ',phpversion('swoole'),PHP_EOL;
echo 'version_compare(): ',version_compare(PHP_VERSION, '7.0.1', '>='),PHP_EOL;


//获取php与服务器之间的api接口类型
echo 'php_sapi_name: '.php_sapi_name(),PHP_EOL;  //apache2handler cli 等

//获取已加载的扩展
echo 'loaded extensions: ',PHP_EOL;
$loaded_extensions =  get_loaded_extensions();
// print_r($loaded_extensions);


//获取phpinfo信息，可以获取不同部分的值
echo 'phpinfo() get INFO_GENERAL:',PHP_EOL;
// print_r(phpinfo(INFO_GENERAL));


