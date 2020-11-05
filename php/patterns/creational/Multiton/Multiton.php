<?php
namespace DesignPatterns\Creational\Multiton;

/**
 * 多例模式，相对于单例模式而言
 * Class Multiton
 * @package DesignPatterns\Creational\Multiton
 */
final Class Multiton
{
    const INSTANCE_1 = '1';
    const INSTANCE_2 = '2';

    /**
     * @var 实例数组
     */
    private static $instances = [];

    //私有构造方法，阻止用户随意创建该对象实例
    private function __construct()
    {
    }

    public static function getInstance($instanceName)
    {
        if (!isset(self::$instances[$instanceName])) {
            self::$instances[$instanceName] = new self();
        }

        return self::$instances[$instanceName];
    }

    //阻止对象被克隆
    private function __clone()
    {}

    //阻止实例被序列化
    private function __wakeup()
    {

    }
}