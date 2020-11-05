<?php

// ****** 1.策略模式 *********

// 策略模式一个典型应用时处理程序算法与其他算法之间的交互。经常与工厂模式一起使用
// 策略模式的实现方法，是通过声明一个抽象的拥有一个算法方法的基类，而且通过继承这个基类的具体类来实现
//  比如一个下载服务器，根据不同的web客户端选择不同的下载策略。win下载.zip,其他下载.tar.gz

abstract class FileNamingStrategy
{
    //抽象方法
    abstract function createLinkName($filename);
}

//下载zip文件
class ZipFileNamingStrategy extends FileNamingStrategy
{
    //具体实现
    function createLinkName($filename)
    {
        return "http://downloads.foo.bar/$filename.zip";
    }
}


class TarGzFileNamingStrategy extends FileNamingStrategy
{
    function createLinkName($filename)
    {
        return "http://donwloads.foo.bar/$filename.tar.gz";
    }
}

if (strstr($_SERVER['HTTP_USER_AGENT'], 'Win')) {
    $fileNameObj = new ZipFileNamingStrategy();
} else {
    $fileNameObj = new TarGzFileNamingStrategy();
}

$cacl_filename = $fileNameObj->createLinkName("Calc101");

print  <<<EOF
<h1>下载列表</h1>
<br>
<a href="$calc_filename">牛逼的计算器</a>
EOF;

// ******** 2. 单例模式 *********
//在整个应用中只需要一个实例对象存在，应用中都可以访问他，比如日志记录。
//单例模式的实现，通常是通过一个静态的类方法getInstance() 实现的

class Logger
{
    private static $instance;

    static function getInstance()
    {
        if(self::$instance == null){
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {

    }

    private function __clone()
    {

    }

    function log($str)
    {
        //记录日志
    }
}


//调用
Logger::getInstance()->log("checkPoint");

// ********* 3. 工厂模式 **********

//多态和基类时使用oop的核心。但是你经常需要创建基类的子类的一个具体实例，这个通常用工厂模式实现。
// 一个工厂类拥有一个静态方法，用来接收一些输入，并根据输入决定应该创建那个类的实例(通常是一个子类)
//比如你的web站点上，有着不同类型的用户登陆，其中一些人时有个，一些是会员，一些时管理员。普通思路是你会需要一个积累user和三个子类：
// GuestUser, CustomerUser, AdminUser. 且最好尽可能多地使用基类User，这样代码会比较规范在需求增加时比较容易添加新用户类型

abstract class User
{
    protected $name = null;

    function __construct($name)
    {
        $this->name = $name;
    }

    function getName()
    {
        return $this->name;
    }
    //权限方法
    function hasReadPermission()
    {
        return true;
    }

    function hasModifiedPermission()
    {
        return false;
    }

    function hasDeletePermission()
    {
        return false;
    }

    //定制的方法
    function wantsFlashInterface()
    {
        return true;
    }
}

//GuestUser
class GuestUser extends User
{

}

//CustomerUser
class CustomerUser extends User
{
    function hasMofidiedPermission()
    {
        return true;
    }
}

//AdminUser
class AdminUser extends User
{
    function hasModifiedPermission()
    {
        return true;
    }

    function hasDeletePermission()
    {
        return true;
    }

    function wantsFlashInterface()
    {
        return false;
    }
}

class UserFactory
{
    private static $users = [
        'Andi' => 'admin',
        'Stig' => 'guest',
        'Derick' => 'customer'
    ];

    static function create($name)
    {
        if(!isset(self::$users[$name])) {
            //报错，用户不存在
            die("用户不存在");
        }
        switch(self::$users[$name]) {
            case "guest": return new GuestUser($name); break;
            case "customer": return new CustomerUser($name); break;
            case "admin": return new AdminUser($name); break;
            default: echo "用户类型不存在\n";
        }
    }
}

function boolToStr($b)
{
    if ($b == true) {
        return "Yes\n";
    } else {
        return "No\n";
    }
}

function displayPermissions(User $obj)
{
    print $obj->getName() . " 's permissions: \n";
    print "Read: " . boolToStr($obj->hasReadPermission());
    print "Modify: " . boolToStr($obj->hasModifiedPermission());
    print "Delete: " . boolToStr($obj->hasDeletePermission());
}


function displayRequirements(User $obj)
{
    if($obj->wantsFlashInterface()) {
        print $obj->getName() . " requires Flash\n";
    }
}

$logins = ["Andi", "Stig", "Derick"];
echo "\n";
foreach($logins as $login) {
    echo "---- $login ----\n";
    displayPermissions(UserFactory::create($login));
    displayRequirements(UserFactory::create($login));
}

// ****** 4. 观察者模式 ******
// 观察者模式允许对象注册到一个特定的时间或者数据，当这个事件发生或者数据改变时，会自动通报
// 比如商品价格，根据不同汇率显示不同的金额。
// 把产品项目开发成一个给与货币汇率的观察者，而在打印项目的条目时，可以驱动一个事件来用正确的汇率更新注册的对象。
// 这样可以让对象有机会自我更新并且在display()中使用新的数据

//(观察者)对被观察者感兴趣的类需要实现这个接口
interface Observer
{
    function notify($obj);
}

//被观察者： 一个对象想要 "可观察"，需要注册一个方法，让观察者对象可以注册自己。
class ExchangeRate
{
    static private $instance;
    private $observers = [];
    private $exchange_rate;

    private function __construct(){

    }

    static public function getInstance()
    {
        if(self::$instance == null)
        {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getExchangeRate()
    {
        return $this->exchange_rate;
    }

    //变化条件，通知所有的观察者
    public function setExchangeRate($new_rate)
    {
        $this->exchange_rate = $new_rate;
        $this->notifyObservers();
    }
    //注册观察者
    public function registerObservers($obj)
    {
        $this->observers[] = $obj;
    }
    //通知观察者变化
    public function notifyObservers()
    {
        foreach($this->observers as $obj) {
            $obj->notify($this); //传递ExchangeRate对象
        }
    }
}

//观察者： 观察汇率变化
class ProductItem implements Observer
{
    public function __construct()
    {
        ExchangeRate::getInstance()->registerObservers($this);
    }
    //观察者需要实现notify()方法
    public function notify($obj)
    {
        if ($obj instanceof ExchangeRate) {
            //更新交易率数据
            print "received update\n";
        }
    }
}
echo '------ observer ------'."\n";
$product1 = new ProductItem();
$product2 = new ProductItem();

ExchangeRate::getInstance()->setExchangeRate(4.5);

// ********************* 映射 *************************
//间接调用函数 $func(...)
// 间接实例化类 (new $classname(...))

//映射：让你实时地收集脚本信息。具体来说，就是检查你的函数、累等。

echo "--------- 映射 -----------\n";
ReflectionClass::export("ReflectionParameter");

//使用映射执行授权模式

echo "--------- 使用映射执行授权模式 -----------\n";
//映射执行授权模式
/*
 * 面向对象开发中，一个雷需要去执行另一个类或者更多其他类的方法的次数越来越多。有时候继承无法解决问题，也不符合逻辑，不满足"是一"的关系
 * 这时候，使用【授权模块】就很有用了。一个类One不具备的方法，可以专项调用类Two，或者一个对象列表中拥有最高优先级的对象中的方法
 */

class ClassOne
{
    function callClassOne()
    {
        print "In class one\n";
    }
}

class ClassTwo
{
    function callClassTwo()
    {
        print "In class two\n";
    }
}

class ClassOneDelegator
{
    private $targets;

    function __construct()
    {
        $this->targets[] = new ClassOne();
    }

    function addObject($object)
    {
        $this->targets[] = $object;
    }

    /**
     * @param $name 方法名
     * @param $args 参数
     * @return mixed
     * @author fz
     * @time   2018/11/6 下午5:55
     */
    function __call($name, $args)
    {
        foreach($this->targets as $obj){

            /*if(method_exists($obj, $name) && is_callable([$obj->$name()])){
                return call_user_func_array([$obj, $name], $args);
            }
            continue;*/

            $r = new ReflectionClass($obj);
            if($r->hasMethod($name) && $method = $r->getMethod($name)) {
                if($method->isPublic() && !$method->isAbstract()){
                    return $method->invoke($obj, $args);
                }
            }
        }
    }
}


$obj = new ClassOneDelegator();
$obj->addObject( new ClassTwo());
$obj->callClassOne();
$obj->callClassTwo();
