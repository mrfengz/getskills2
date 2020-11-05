<?php
//定义常量，定义接口函数。一般当类需要额外的约定时，使用接口
//接口总被认为时public的
//接口方法不能重复定义
//接口可以继承
interface Loggable
{
    function logString();
}

class Person implements Loggable
{
    private $name, $address, $idNumber, $age;
    function logString()
    {
        return "Class Person: name=>$this->name, ID=$this->idNumber\n";
    }
}

class Product implements Loggable
{
    private $name, $price, $expiryDate;
    function logString()
    {
        return "Class Product: name=$this->name, price=$this->price\n";
    }
}


function myLog($obj)
{
    if($obj instanceof Loggable){
        print $obj->logString();
    } else {
        print "Error: Object doesn't support loggable interface\n";
    }
}

$person = new Person();
$product = new Product();
myLog($person);
myLog($product);


// 接口继承
interface f extends F1, F2{
    //do something
}
