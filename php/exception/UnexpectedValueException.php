<?php
namespace http\Exception;
class BadValueException extends \UnexpectedValueException
{
}



namespace run;
use http\Exception\BadValueException as BadValue;
use http\Exception\BadValueException;

class Run {
    public function index() {
        throw new BadValue('delibated');
    }
}
try {
    try {
        (new Run())->index();
    } catch (BadValue $e) {
        echo 111;
        throw $e;
    }
} catch(BadValueException $e) {
    echo 222;
    var_dump($e->getMessage());
}
