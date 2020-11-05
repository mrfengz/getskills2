<?php
namespace DesignPatterns\Creational\Prototype;

/**
 * 原型模式 相比正常创建一个对象，先创建原型然后克隆更节省开销
 *  大量数据插入
 * Class BookPrototype
 * @package DesignPatterns\Creational\Prototype
 */
abstract class BookPrototype
{
    /**
     * @var string
     */
    protected $title;

    protected $category;

    abstract public function __clone();

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }
}