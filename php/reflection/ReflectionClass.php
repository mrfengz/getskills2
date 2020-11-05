<?php
/*if(php_sapi_name() != 'cli')
    exit('I just wanna to run in cli.');*/

function p($prm)
{
    print_r($prm);
    echo PHP_EOL;
}


interface foo{}

interface bar{}

/**
 * Class Test
 * Just for test
 * @param Exception $e
 */
class Test implements foo, bar
{
    const TYPE='test';
    const AGE= 18;

    public $name;
    private $gender;
    protected $age;

    /**
     * Test constructor.
     * @param $name
     * @param $age
     * @param string $gender
     */
    public function __construct($name, $age, $gender='secret')
    {
        $this->name = $name;
        $this->age = $age;
        $this->gender = $gender;
    }

    private function getAge()
    {
        return $this->age;
    }
}

$reflector = new ReflectionClass('Test');
$constant = $reflector->getConstant('TYPE');
echo "const: ". $constant.PHP_EOL;

$constants = $reflector->getConstants();
print_r($constants);

//constructor
print_r($reflector->getConstructor());

//defaultProperties
print_r($reflector->getDefaultProperties());

// 类的docComment
print_r($reflector->getDocComment());

//getEndLine
print_r($reflector->getEndLine());

//getExtension
print_r((new ReflectionClass('Swoole\Server'))->getExtension());
echo ((new ReflectionClass('Swoole\Server'))->getExtensionName());

//getFileName
echo($reflector->getFileName());

//getInterface
print_r($reflector->getInterfaces());
print_r($reflector->getInterfaceNames());

//getMethod
print_r($reflector->getMethods(ReflectionMethod::IS_PRIVATE));
print_r($reflector->getMethod('getAge'));

//getModifiers 该类的Modifiers
print_r($reflector->getModifiers());

//类名
p($reflector->getName());

//命名空间
p('命名空间'.$reflector->getNamespaceName());

// $export = Reflection::export(new ReflectionClass('Exception'));
