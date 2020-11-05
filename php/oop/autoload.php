<?php


function my_autoload($class){
    $document_dir = __DIR__.'/';
    $classArr = explode('\\', $class);
    $namespace = array_shift($classArr);
    $dir = $document_dir.$namespace.'/';
    if (!is_dir($dir)) {
        exit('不存在'.$dir.'目录');
    }
    $className = array_pop($classArr);
    while(count($classArr)) {
        $dir .= array_shift($classArr).'/';
        if (!is_dir($dir)) {
            exit('不存在'.$dir.'目录');
        }
    }
    if (!is_file($classFile = $dir.$className.'.php')) {
        exit('不存在'.$classFile.'文件');
    }

    require $classFile;
    if (!class_exists($class)) {
        exit('文件中不存在指定的类'.$class);
    }

}

spl_autoload_register('my_autoload');
