<?php
$swoole = ini_get_all('swoole', false);
print_r($swoole);



//ini_set()

//ini_get()     //获取设置的值

//ini_restore() 恢复设置之前的值

echo "expose_php: ".ini_get('expose_php'),PHP_EOL;

ini_set('expose_php', 0); //only php.ini可以设置
echo "set expose_php to false: ".ini_get('expose_php'),PHP_EOL;
ini_restore('expose_php');
echo 'ini_restore expose_php: '.ini_get().PHP_EOL;



echo "php_ini_loaded_file(): ".php_ini_loaded_file().PHP_EOL;

echo 'php_ini_scanned_files(): '.PHP_EOL;
    print_r(php_ini_scanned_files());


