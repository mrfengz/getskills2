<?php
// 依赖注入： 构造函数注入、属性注入

//为邮件服务定义抽象层
interface EmailSenderInterface
{
	public function send(...);
}

// 定义Gmail邮件服务
class GmailSender implements EmailSenderInterface
{
	public function send(...) {
		//todo
	}
}

// 定义评论类
// 该类依赖于GmailSender服务，如果以后改为YahooSender,不得不修改代码，不便利
class Comment extends yii\db\ActiveRecord
{
	// 定义发送邮件使用的服务
	private $_emailSender;


	// 初始化时，实例化邮件服务
	public function init()
	{
		$this->_emailSender = GmailSender::getInstance();
	}


	// 有新的评价后，触发发送邮件的方法
	public function afterInsert()
	{
		$this->_emailSender->send(...);
	}
}


// ----------------- 依赖注入 -------------------
// 构造函数注入
class Article extends yii\db\ActiveRecord
{
	private $_emailSender;

	// 构造函数注入
	public function __construct($emailSender)
	{
		$this->_emailSender = $emailSender;
	}

	public function afterSave()
	{
		$this->_emailSender->send(...);
	}
}
//实例化邮件服务
$sender1 = new YahooEmail();
$sender2 = new GmailEmail();

// 通过注入的yahoo邮件服务发送邮件
$article1 = new Atricle($sender1);
$article1->save();

// 通过注入的gmail邮件服务发送邮件
$article2 = new Article($sender2);
$article2->save();

// ----- 属性注入 --------
class Comment2
{
	private $_emailSender;

	public function setEmailSender($value)
	{
		$this->_emailSender = $value;
	}

	public function afterSave()
	{
		$this->_emailSender->save(...);
	}
}

$comment = new Comment2();
// 使用属性注入
$comment->emailSender = new GmailSender;
$comment->save();

// ------------------------ DI容器 -----------------------
// 从上面DI两种注入方式来看，依赖单元的实例化代码是一个重复、繁琐的过程。 可以想像，一个Web应用的某一组件会依赖于若干单元，这些单元又有可能依赖于更低层级的单元， 从而形成依赖嵌套的情形。那么，这些依赖单元的实例化、注入过程的代码可能会比较长，前后关系也需要特别地注意， 必须将被依赖的放在需要注入依赖的前面进行实例化。 这实在是一件既没技术含量，又吃力不出成果的工作，这类工作是高智商（懒）人群的天敌， 我们是不会去做这么无聊的事情的。


class Instance
{
	//仅有的属性，用于保存雷鸣、接口名或者别名
	public $id;

	// 构造函数，仅将传入的ID赋值给$id属性
	protected function __construct($id)
	{
	}

	// 静态方法，创建一个Instance实例
	public static function of($id)
	{
		return new static($id);
	}

	// 静态方法，用于将引用解析成实际的对象，并确保这个对象的类型
	public static function ensure($reference, $type = null, $container = null) 
	{

	}

	// 获取这个实例所引用的实际对象，事实上它调用的是 
	// yii\di\Container::get()来获取实际的对象
	public function get($container = null)
	{

	}
}

//DI容器的数据结构

// 单例类型主要用于节省构建实例的时间、内存、共享数据等
class DI 
{
	// 用于保存单例Singleton对象，以对象类型为键
	private $_singletons = [];

	// 用于保存依赖的定义，以对象类型为键
	private $_definitions = [];

	// 用于保存构造函数的参数，以对象类型为键
	private $_params = [];

	// 用于缓存ReflectionClass对象，以类名或接口名为键
	private $_reflections = [];

	// 用于缓存依赖信息，以类名或接口名为键
	private $_dependencies = [];
} 

// 要是用DI容器，需要先告诉容器，类型及类型之间的依赖关系，声明这一关系的过程称为注册依赖

class Container
{
	
	public function set($class, $definition = [], array $params = [])
	{
		// 规范化 $definition 并写入 $_definitions[$class]
		$this->_definitions[$class] = $this->normalizeDefinition($class, $definition);

		// 将构造函数参数写入 $_params[$class]
		$this->_params[$class] = $params;

		//删除$_singletons[$class]
		unset($this->_singletons[$class]);

		return $this;
	}

	public function setSingletion($class, $definition = [], array $params = [])
	{
		// 规范化 $definition 并写入 $_definitions[$class]
		$this->_definitions[$class] = $this->normalizeDefinition($class, $definition);

		// 将构造函数参数写入 $_params[$class]
		$this->_params[$class] = $params;

		//将$_singletons[$class]设置为null，表示还未实例化
		$this->_singletons[$class] = null;

		return $this;
	}

	protected function normalizeDefinition($class, $definition)
	{
		// $definition 是空的转换成 ['class' => $class] 形式
		if(empty($definition)) {
			return ['class' => $class];
		// $definition 是字符串，转换成 ['class' => $definition] 形式		
		} elseif (is_string($definition)) {
			return ['class' => $definition];
		// $definition 是PHP callable 或对象，则直接将其作为依赖的定义	
		} elseif (is_callable($definition, true) && is_object($definition)) {
			return $definition;
		// $definition 是数组则确保该数组定义了 class 元素
		} elseif (is_array($definition)) {
			if (!isset($definition['class'])) {
				if (strpos($class, '\\') !== false) {
					$definition['class'] = $class;
				} else {
					throw new InvalidConfigException("A class definition requires a \"class\" member.")
				}
			}
			return $definition;
		// 这也不是，那也不是，那就抛出异常算了
		} else {
			throw new InvalidConfigException("Unsupport definition type for \"class\": ". gettype($definition));
		}
	}

	// 生成$reflection(ReflectionClass)和依赖缓存$dependencies
	public function getDependencies($class) 
	{
		// 如果已经缓存了其依赖信息，直接返回缓存中的依赖信息
		if (isset($this->_reflections[$class])) {
			return [$this->_reflections[$class], $_dependencies[$class]];
		}

		$dependencies = [];

		$reflection = new ReflectionClass($class);

		$constructor = $reflection->getConstructor();
		if ($constructor == null) {
			foreach ($constructor->getParameters() as $param) {
				if ($param->isDefaultValueAvaliable()) {
					$dependencies[] = $param->getDefaultValue();
				} else {
					// 获取参数类型提示
					$c = $param->getClass();

					// getName() 获取参数名
					$dependencies[] = Instance::of($c === null ? null : $c->getName());
				}
			}

		}

		// 将ReflectionClass 对象缓存起来
		$this->_reflections[$class] = $reflection;

		// 将依赖信息缓存起来
		$this->_dependencies[$class] = $dependencies;

		return [$reflection, $dependencies];
	}

	// 解析依赖，返回依赖的实例化对象数组
	protected function resolveDependencies($dependencies, $reflection = null)
	{
		foreach ($dependencies as $index => $dependency)
		{
			// 前面getDependencies()函数往 $_dependencies[] 中写入的是一个Instance数组
			if ($dependency instanceof Instance) {
				if ($dependency->id !== null) {
					// 向容器所有所依赖的实例，递归调用 \yii\di\Container::get()
					$dependencies[$index] = $this->get($dependency->id);
				} elseif ($reflection !== null) {
					$name = $reflection->getConstructor()
						->getParameters()[$idex]->getName();

					$class = $reflection->getName();

					throw new InvalidConfigException("Missing required parameter \"$name\" when instanting \"$class\".");	
				}
			}
		}
		return $dependencies;
	}

	protected function build($class, $params, $config)
	{
		// 获取reflectionClass()和依赖的对象参数
		list($reflection, $dependencies) = $this->getDependencies($class);

		// 用传入的 $params 的内容补充，覆盖到依赖信息中
		foreach($params as $index => $param) {
			$dependencies[$index] = $param;
		}

		// 这个语句是两个条件：
		// 1.要创建的类是一个 yii\base\Object 类, 这个类对构造函数的参数是有一定要求的
		// 2.依赖信息不为空，也就是要么已注册过依赖，要么为build()传入构造函数参数
		if (empty($dependencies) && is_a($class, 'yii\base\Object', true)) {
			// 按照Object类的要求，构造函数的最后一个参数为$config数组
			$dependencies[count($dependencies) - 1] = $config;

			// 解析依赖信息，如果有依赖单元需要提前实例化，会在这一步完成
			$dependencies = $this->resolveDependencies($dependencies, $reflection);
			// 实例化这个对象
			return $reflection->newInstanceArgs($dependencies);
		} else {
			// 会出现异常的清空有二
			// 1. 依赖信息为空，也就是前面你又没有注册过，现在又不提供构造函数参数
			// 2. 要构造的类，根本就不是 Object 类
		}
	}

	// 返回一个对象或一个别名所代表的的对象。
	// 可以是已经注册好的，也可以是没有注册过依赖的
	// 
	/* 以传入的 $class 看看容器中是否已经有实例化好的单例，如有，直接返回这一单例。
如果这个 $class 根本就未定义依赖，则调用 build() 创建之。具体创建过程等下再说。
对于已经定义了这个依赖，如果定义为PHP callable，则解析依赖关系，并调用这个PHP callable。 具体依赖关系解析过程等下再说。
如果依赖的定义是一个数组，首先取得定义中对于这个依赖的 class 的定义。 然后将定义中定义好的参数数组和配置数组与传入的参数数组和配置数组进行合并， 并判断是否达到终止递归的条件。从而选择继续递归解析依赖单元，或者直接创建依赖单元。
	
	注意：
	1.对于已经实例化的单例，使用 get() 时只能返回已经实例化好的实例， $params 参数和 $config 参数失去作用。这点要注意，Yii不会提示你，所给出的参数不会发生作用的。 有的时候发现明明已经给定配置数组了，怎么配置不起作用呀？就要考虑是不是因为这个原因了。
	2.对于定义为数组的依赖，在合并配置数组和构造函数参数数组过程中， 定义中定义好的两个数组会被传入的 $config 和 $params 的同名元素所覆盖， 这就提供了获取不同实例的可能。
	3.在定义依赖时，无论是使用 set() 还是使用 setSingleton() 只要依赖定义为特定对象或特定实例的， Yii均将其视为单例。在获取时，也将返回这一单例。

	*/
	public function get($class, $params = [], $config = [])
	{
		// 已经有一个完成实例化的单例，直接引用这个单例
		if (isset($this->_singletons[$class])) {
			return $this->_singletons[$class];
		// 是个尚未注册过的依赖，说明它不依赖其他单元，或者依赖信息不用定义，则根据传入的参数创建一个实例 	
		} elseif (!isset($this->_definitions[$class])) {
			return $this->build($class, $params, $config);
		}

		$definition = $this->_definitions[$class];

		// 依赖的定义是个回调函数，直接调用
		if (is_callable($definition, true)) {
			$params = $this->resolveDependencies($this->mergeParams($class, $params));
			$object = call_user_func($definition, $this, $params, $config);
		// 依赖的定义是个数组，合并相关的配置和参数，创建之
		} elseif (is_array($definition)) {
			$concrete = $definition['class'];
			unset($definition['class']);

			// 合并将依赖定义中配置数组和参数数组与传入的配置数组和参数数组合并
			$config = array_merge($definition, $config);
			$params = $this->mergeParams($class, $params);

			if ($concrete === $class) {	//终止递归的重要条件
				$object = $this->build($class, $params, $config);
			} else {	//递归解析
				$object = $this->get($concrete, $params, $config);
			}
		// 依赖的定义是个对象，则应当保存为单例
		} elseif (is_object($definition)) {
			return $this->_singletons[$class] = $definition;
		} else {
			throw new InvaliConfigException("Unexpected object definition type: ".gettype($definition));
		}

		// 依赖的定义已经定义为单例的，应该实例化该对象
		if (array_key_exists($class, $this->_singletons)) {
			$this->_singletons[$class] = $object;
		}

		return $object;
	}
}

$container = new \yii\di\container;
// $_definitions['yii\db\Connection'] = 'yii\db\Connection';
$container->set('yii\db\Connection');

// 注册一个接口，当一个类依赖于改接口时，定义中的类会自动被实例化，并供有依赖需要的类使用
$container->set('\yii\mail\MailInterface', 'yii\swiftmailer\Mailer');

// 注册一个别名，当调用$container->get('foo')时，可以得到一个Connection实例
$contianer->set('foo', 'yii\db\Connection');

// 使用配置数组注册一个类，需要这个类的实例时，配置数组会被使用
// $_definitions['yii\db\Connection'] = [...];
$container->set('yii\db\Connection', [
	'dsn' => 'mysql:host=127.0.0.1;dbname=demo',
	'username' => 'root',
	'password' => '',
	'charset' => 'utf8'
]);

// 用一个配置数组来注册一个别名，由于别名的类型不详，所以需要有class元素
$container->set('db', [
	'class' => 'yii\db\Connection',
	'dsn' => 'mysql:host=127.0.0.1;dbname=demo',
	'username' => 'root',
	'password' => '',
	'charset' => 'utf8'
]);

// 使用PHP callable来注册一个别名，每次引用这个别名时，这个callable都会被调用
$container->set('db', function($container, $params, $config) {
	return new \yii\db\Connection($config);
});

// 用一个对象来注册一个别名，每次引用这个别名时，这个对象都会被引用
$container->set('pageCache', new FileCache());


// 实例分析di
namespace app\models;

use yii\base\Object;
use yii\db\Connection;

// 定义接口
interface UserFinderInterface
{
	function findUser();
}


class UserFinder extends Object implements UserFinderInterface
{
	public $db;

	// 从构造函数看，这个类依赖于Connection
	public function __construct(Connection $db, $config = [])
	{
		$this->db = $db;
		parent::__construct($config);
	}

	public function findUser()
	{

	}
}


class UserLister extends Object
{
	public $finder;

	// 从构造函数看，这个类依赖UserFinderInterface接口
	public function __construct(UserFinderInterface $finder, $config = [])
	{
		$this->finder = $finder;
		parent::__construct($config);
	}
}

// 常规操作手法. 逆着顺序创建
$db = new \yii\db\Connection(['dsn' => '...']);
$finder = new UserFinder($db);
$lister = new UserLister($finder);

// di容器写法
use yii\db\Container;

// 创建一个di容器
$container = new Container;

// 为Connection指定一个数组作为依赖，
// 当需要Connection的实例时，使用这个数组进行创建
$container->set('yii\db\Connection', [
	'dsn' => '...',
]);

// 在需要使用接口UserFinderInterface 时，采用UserFinder类实现
$container->set('app\models\UserFinderInterface', [
	'class' => 'app\models\UserFinder',
]);

// 为 UserLister 定义一个别名
$container->set('userLister', 'app\models\UserLister');

/* 经过上面几个set()语句之后
$_definitions = [
	'yii\db\Connection' => [
		'class' => 'yii\db\Connection',
		'dsn' => ...
	],
	'app\models\UserFinderInterface' => [
		'class' => 'app\models\UserFinder'
	],
	'userLister' => [
		'class' => 'app\models\UserLister'
	]
];

 */

// 获取这个UserLister实例
$lister = $container->get('userLister');