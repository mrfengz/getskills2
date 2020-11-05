<?php
class Vegetable
{
    public $editable;
    public $color;

    function __construct($editable, $color = 'green')
    {
        $this->editable = $editable;
        $this->color = $color;
    }

    function is_editable()
    {
        return $this->editable;
    }

    function what_color()
    {
        return $this->color;
    }

}


class Spinach extends Vegetable
{
    public $cooked = false;

    function __construct()
    {
        parent::__construct(true, 'green');
    }

    function cook_it()
    {
        $this->cooked = true;
    }

    function is_cooked()
    {
        return $this->cooked;
    }
}


function print_vars($obj){
    foreach(get_object_vars($obj) as $prop=>$val) {
        echo "\t $prop = $val\n";
    }
}

function print_methods($obj) {
    $arr = get_class_methods(get_class($obj));
    foreach($arr as $method) {
        echo "\t function: $method ()\n";
    }
}

function class_parentage($obj, $class) {
    if (is_subclass_of($GLOBALS[$obj], $class)) {
        echo "Object $obj belongs to class ".get_class($GLOBALS[$obj]);
        echo " a subclass of $class\n";
    } else {
        echo "Object $obj does not belong to a subclass of $class\n";
    }
}


$veggie = new Vegetable(true, 'blue');
$leafy = new Spinach();

echo "Veggie: CLASS " . get_class($veggie) . "\n";
echo "Leafy: CLASS " . get_class($leafy) . "\n";
echo ", parent " . get_parent_class($leafy) . "\n";

//打印属性
echo "\n veggie: Propertities \n";
print_vars($veggie);

//打印leafy的methods
echo "\n leafy methods: \n";
print_methods($leafy);

echo "\n Parentage: \n";
class_parentage("leafy", "Spinach");
class_parentage("leafy", "Vegetable");