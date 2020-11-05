<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class A
{
    public $one = '';
    public $two = '';

    public function __construct()
    {
    }

    public function echoOne()
    {
        echo $this->one."\n";
    }

    //print variable two
    public function echoTwo()
    {
        echo $this->two."\n";
    }
}

$a = new A();

//实例化Reflection对象
$reflector = new ReflectionClass('A');

$properties = $reflector->getProperties();
$i = 1;

foreach($properties as $property) {
    //填充属性
    $a->{$property->getName()} = $i;
    //调用对象方法
    $a->{"echo".ucfirst($property->getName())}()."\n";
    $i++;
}

echo Reflection::export($reflector, true);

print_r(Reflection::getModifierNames(ReflectionClass::IS_IMPLICIT_ABSTRACT ));
