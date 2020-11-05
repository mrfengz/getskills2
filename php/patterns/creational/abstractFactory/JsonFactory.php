<?php
namespace DesignPatterns\Creational\AbstractFactory;

use SebastianBergmann\CodeCoverage\Report\Text;

class JsonFactory extends AbstractFactory
{
    public function createText(string $content): Text
    {
        return new JsonText();
    }
}
