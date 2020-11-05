<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/10/3
 * Time: 14:30
 */

function f1($x)
{
    $x += 3;
    print 'x='.$x.PHP_EOL;
}

function f2(&$x)
{
    $x += 3;
    print 'x='.$x.PHP_EOL;
}

$a = 5;
f1($a);
echo "after call f1, a=$a\n";
f2($a);
echo "after call f2, a=$a\n";

class test{
    private $x;

    function __construct($x)
    {
        $this->x = $x;
    }

    function &get_x()
    {
        return $this->x;
    }

    function show_x()
    {
        echo $this->x;
    }
}
$test = new test(10);
$c = &$test->get_x(); //实际是对$test->x变量的引用
$c -= 5;
echo $c, '--', $test->show_x();