<?php
//多态 使用类和继承，复用代码，可扩展

//不可扩展示例
class Cat
{
    function miau()
    {
        print "miau";
    }
}

class Dog
{
    function wuff()
    {
        print "wuff";
    }
}

function printTheRightSound($obj)
{
    if($obj instanceof Cat) {
        $obj->miau();
    } else if($obj instanceof Dog) {
        $obj->wuff();
    } else {
        print "Error:Pass wrong kind of object";
    }
    print "\n";
}

printTheRightSound(new Cat());
printTheRightSound(new Dog());

//多态使用继承来解决这个问题，继承所有父类的方法和属性然后创建"是一"的关系

class Animal
{
    function makeSound()
    {
        print "Error: This method should be re-implemented in the children";
    }
}

class Cat2 extends Animal
{
    function makeSound()
    {
        print "maiu\n";
    }
}

class Dog2 extends Animal
{
    function makeSound()
    {
        print "wuff\n";
    }
}

function printTheRightSound2($obj)
{
    if($obj instanceof Animal) {
        $obj->makeSound();
    } else {
        print "Error: Passed wrong kind of objetc\n";
    }
}

printTheRightSound2(new Cat2());
printTheRightSound2(new Dog2());
