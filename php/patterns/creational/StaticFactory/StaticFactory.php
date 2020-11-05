<?php
namespace DesignPatterns\Creational\StaticFactory;

final class StaticFactory
{
    public static function factory(string $type): FormatterInterface
    {
        switch($type) {
            case 'number':
                return new FormatterNumber();
            case 'string':
                return new FormatterString();
            default:
                throw new \InvalidArgumentException("unknown formatter type");
        }
    }
}