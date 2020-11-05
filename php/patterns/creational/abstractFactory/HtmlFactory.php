<?php
namespace DesignPatterns\Creational\AbstractFactory;

class HtmlFactory extends AbstractFactory
{
    public function createText(string $content): Text
    {
        // TODO: Implement createText() method.
        return new HtmlText();
    }
}
