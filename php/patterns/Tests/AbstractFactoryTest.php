<?php
namespace DesignPatterns\Creational\Tests;

use DesignPatterns\Creational\AbstractFactory\HtmlFactory;
use DesignPatterns\Creational\AbstractFactory\JsonFactory;
use DesignPatterns\Creational\AbstractFactory\HtmlText;
use DesignPatterns\Creational\AbstractFactory\JsonText;
use PHPUnit\Framework\TestCase;

class AbstractFactoryTest extends TestCase
{
    public function testCanCreateHtmlText()
    {
        $factory = new HtmlFactory();
        $text = $factory->createText();

        $this->assertInstanceOf(HtmlText::class, $text);
    }
}
