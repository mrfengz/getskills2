<?php
namespace DesignPatterns\Tests;

class Loader
{
    /**
     * @var array 命名空间 命名空间-->路径
     */
    private static $namespaces = [];
    /**
     * @var array 类名-->路径
     */
    private static $map = [];

    public static function register()
    {
        self::addNamespace('DesignPatterns', dirname(__DIR__).DIRECTORY_SEPARATOR);
        spl_autoload_register("\DesignPatterns\Tests\Loader::autoload", true, true);
    }

    public static function autoload($class)
    {
        if ($file = self::find($class)) {
            include $file;
            return true;
        }
    }

    public static function find($class)
    {
        if(!empty(self::$map[$class])){
            return self::$map[$class];
        }

        $classes = explode('\\', $class);
        $namespace = array_shift($classes); //获取类名第一段，作为命名空间
        $logicalPath = join(DIRECTORY_SEPARATOR, $classes); //剩下的部分，作为class路径，需要将命名空间的 \\ 转为 directory_separator

        if (isset(self::$namespaces[$namespace]) && is_file($path = self::$namespaces[$namespace] . $logicalPath . '.php')) {
            self::addMap($class, $path);
            return $path;
        } else {
            echo "找不到啊，你看看是命名空间不对还是文件路径不对~";
            return false;
        }

    }


    public static function addMap($class, $path)
    {
        self::$map[$class] = $path;
    }

    /**
     * 注册命名空间
     * @param $name 命名空间
     * @param $path 对应的目录
     */
    public static function addNamespace($name, $path)
    {
        self::$namespaces[$name] = rtrim($path, '/').DIRECTORY_SEPARATOR;
    }
}