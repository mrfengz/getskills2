<?php
// 1 class_alias
class foo{}

class_alias('foo', 'bar');
$a = new foo();
$b = new bar();

var_dump($a == $b, $a === $b);

var_dump($b instanceof $a);

// 2 class_exists($cls, $autoload = true)

function __autoload($class) {
    include($class . '.php');
    if (!class_exists($class, false)) {
        trigger_error("unable to load class: $class", E_USER_WARNING);
    }
}

if (class_exists("MyClass")) {
    $myclass = new Myclass();
}

//3 get_declared_classes()

print_r(get_declared_classes());

$redis = new Redis();
// $redis->connect('127.0.0.1', 6379);

//4 get_called_class() 获取实际调用的类，而不是定义的类
class foo2
{
    static function test()
    {
        var_dump(get_called_class());
    }

    function whoruns()
    {
        echo 'runs by: '.get_called_class(). "\n";
    }
}

class bar2 extends foo2{}

foo2::test();
bar2::test();

$f2 = new foo2();
$b2 = new bar2();
$f2->whoruns();
$b2->whoruns();
