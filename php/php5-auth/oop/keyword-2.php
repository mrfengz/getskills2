<?php
error_reporting(-1);
ini_set('display_errors', 1);

// ********* Child and Parent **********

// 尽量使用parent,而不是直接使用父类的名字，方便修改类的层次
class Ancestor
{
    const NAME="Ancestor";
    function __construct()
    {
        print "In ". self::NAME. " constructor\n";
    }
}

class Child Extends Ancestor
{
    const NAME = "Child";
    function __construct()
    {
        parent::__construct();
        print "In ". self::NAME . " constructor\n";
    }
}

$obj = new Child();

// ****** instanceof ********

class Rectangle
{
    public $name=__CLASS__;
}

class Square extends Rectangle
{
    public $name = __CLASS__;
}

class Circle
{
    public $name = __CLASS__;
}

function checkIfRectangle($shape)
{
    if($shape instanceof Rectangle){
        print $shape->name;
        print "\t is a rectangle\n";
    }
}

checkIfRectangle(new Square()); // square is a rectangle
checkIfRectangle(new Circle()); // nothing to output

// *********** final 不允许继承、重载 ************

final class BaseClass
{

}
//报错 class EBase may not inherit from final class
// class EBase extends BaseClass
// {
//
// }

// ******** instanceof 类型提示***********

function onlyWantMyClassObjects($obj)
{
    if(!$obj instanceof MyClass) {
        die("only data objects of type MyClasss can be send to this function\n");
    }
}

//or
function onlyWantMyClassObjects2 (MyClass $obj)
{
    // ...
}
