<?php
$a = 1;
$b = $c = 0;

function test_global()
{
    global $a, $b;
    $b = &$a;
    $a = 3;
}

echo $a . PHP_EOL;
echo $b . PHP_EOL;


function test_globals()
{
    $GLOBALS['b'] = $GLOBALS['a'];
    $GLOBALS['a'] = 55;
    unset($GLOBALS['c']);
}

test_globals();

echo $a . PHP_EOL;
echo $b . PHP_EOL;
var_dump( $c);
