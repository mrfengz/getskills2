<?php

var_dump(extension_loaded('xdebug'));


include 'EventFactory.php';

$instance = \Kolt\Libs\Event::getInstance();

$instance->register('hello', function(){var_dump(func_get_args());}, true, false);

$instance->trigger('hello', ['name' => 'jack', 'age' => 23]);