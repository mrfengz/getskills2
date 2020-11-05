<?php
//abstract
// 1.不能被直接实例化
// 2.只要有一个方法被定义为abstract,即必须将类也声明为abstract
// 3.特别适合多态，不同对象的同一行为不相同
// 4.抽象方法只能有定义，不能有具体实现

abstract class Shape
{
    protected $x, $y;

    function setCenter($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    abstract function draw();
}

class Square extends Shape
{
    function draw()
    {
        print "我来画个圆..\n";
    }
}

class Circle extends Shape
{
    function draw()
    {
        print "我要画鸡蛋..\n";
    }
}


