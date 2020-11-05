<?php

/*
function __get($property)
function __set($property, $value);
function __call($method, $args);
*/
class Person
{
    private $name;
    function __construct($name)
    {
        $this->name = $name;
    }

    public function __toString()
    {
        return $this->name;
    }
}

$p = new Person("Andi Gustmans");
// print_r($p);
/*class Person#1 (1) {
  private $name =>
  string(13) "Andi Gustmans"
}
*/

echo $p;


// ****** Exception *******

try {
    throw SomeException();
} catch(FirstExcetpion $e) {
    //do 1
} catch(SecondException $e) {
    if ($e instanceof HttpException) {
        //do 2
    } else {
        //do 3
    }
}
/*
class Exception
{
    protected $message;
    protected $code;
    protected $line;
    protected $file;

    function __construct([$message[, $code]]){}

    final public function getMessage();
    final public function getCode();
    final public function getFile();
    final public function getLine();
    final public function getTrace();
    final public function getTraceAsString();
}
*/
class NullHandleException extends Exception
{
    function __construct($message)
    {
        parent::__construct($message);
    }
}


function printObject($obj)
{
    if($obj == null){
        throw new NullHandleException("printObject receive null object\n");
    }
    print $obj."\n";
}

class MyName
{
    function __construct($name)
    {
        $this->name = $name;
    }

    function __toString()
    {
        return $this->name;
    }
}

try {
    printObject(new MyName("BIll"));
    printObject(null);
} catch(NullHandleException $e) {
    print $e->getMessage();
    print " in file " . $e->getFile() . "\n";
    print " on Line " . $e->getLine() . "\n";
} catch(\Exception $e) {
    //not come here
}

// ********* __autoload() ***********
//general.inc
function __autoload($classname)
{
    require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/$classname.php");
}

//new class file
// include "general.inc"
$obj = new SomeClass();

// ********* __get() and __set() *********
class StrictCoordinateClass
{
    private $arr = array('x' => null, 'y' => null);

    function __get($property) {
        if(array_key_exists($property, $this->arr)) {
            return $this->arr[$property];
        } else {
            print "不存在这个属性";
        }
    }

    function __set($property, $value)
    {
        if(array_key_exists($property, $this->arr)) {
            $this->arr[$property] = $value;
        } else {
            print "不存在这个属性";
        }
    }
}

// ******** __call() **********

//建立一个授权模型
class HelloWorld
{
    function display($count)
    {
        for($i=0; $i < $count; $i++)
        {
            echo "Hello, world\n";
        }
        return $count;
    }
}

class HelloWorldDelegator
{
    function __construct()
    {
        $this->obj = new HelloWorld();
    }

    function __call($method, $args)
    {
        //调用$obj中的方法
        return call_user_func_array(array($this->obj, $method), $args);
    }
}

$obj = new HelloWorldDelegator();
print $obj->display(3);

//使用数组语法访问的重载
class UserToSocialSecurity implements ArrayAccess
{
    function offsetExists($name){
        return $this->db->userExists($name);
    }

    function offsetGet($name) {
        return $this->db->getUserId($name);
    }

    function offsetSet($name, $id)
    {
        $this->db->setUserId($name, $id);
    }

    function offsetUnset($name)
    {
        $this->db->removeUser($name);
    }
}

$userMap = new UserToSocialSecurity();
print "Jonh's ID number is " . $userMap['John']; //将会调用offsetGet()方法， 类似于访问 $user->getUserId()
