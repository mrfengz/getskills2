<?php

// ********* 使用数组语法访问的重载 ********
/*
 interface ArrayAccess
mixed offsetGet($index)
mixed offsetExists($index)
mixed offsetSet($index, $new_value)
void offsetUnset($index)

print "John's ID number is ".$db->findIdByNumber("John");
print "John's ID number is ".$userMap['John']; //会调用offsetGet('John')方法
 */
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


// ******* 迭代器  ********
//Traversable 实现该接口的类就可以使用foreach
//IgeratorAggregate / Iterator  (interface) 都继承自Traversable接口，所以可以遍历

class MyClass
{
    public $name="John";
    public $sex = "male";
}

$obj = new MyClass();
foreach($obj as $key => $value)
{
    print "obj[$key] = $value\n";
}

/*
Iterator
    current()
    key()
    next()
    valid()
    rewind()
 */

/**
 * Class NumberSquared
 */
class NumberSquared implements Iterator{
    private $start;
    private $end;
    private $cur;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function rewind()
    {
        $this->cur = $this->start;
    }

    public function key()
    {
        return $this->cur;
    }

    public function current()
    {
        return pow($this->cur, 2);
    }

    public function next()
    {
        $this->cur++;
    }

    //返回 true, false 在调用current()和key() 之前调用
    public function valid()
    {
        return $this->cur <= $this->end;
    }
}

$obj = new NumberSquared(3, 7);
foreach($obj as $key => $value)
{
    print "The square of $key is $value\n";
}


/*
 IteratorAggerate
Iterator getIterator()
 */
class NumberSquared2 implements IteratorAggregate
{
    private $start, $end;
    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function getIterator()
    {
        return new NumberSquaredIterator($this);
    }

    public function getStart()
    {
        return $this->start;
    }

    public function getEnd()
    {
        return $this->end;
    }
}


class NumberSquaredIterator implements Iterator
{
    private $cur;
    private $obj;

    function __construct($obj)
    {
        $this->obj = $obj;
    }

    public function rewind()
    {
        $this->cur = $this->obj->getStart();
    }

    public function key()
    {
        return $this->cur;
    }

    public function current()
    {
        return pow($this->cur, 2);
    }

    public function next()
    {
        $this->cur++;
    }

    public function valid()
    {
        return $this->cur <= $this->obj->getEnd();
    }
}

$obj = new NumberSquared2(2,6);
foreach($obj as $k => $value)
{
    echo "obj[$k] => $value\n";
}
