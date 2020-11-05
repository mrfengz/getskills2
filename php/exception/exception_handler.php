<?php
function dft_handler(Exception $e)
{
    print "Exception: \n";
    $code = $e->getCode();
    if (!empty($code)) {
        printf("Error code: %d\n", $code);
    }
    print $e->getMessage() . "\n";
    print "Line: ".$e->getLine() . "\n";
    print "File: ".$e->getFile() . "\n";
    exit(-1);
}

set_exception_handler('dft_handler');
$file = new SplFileObject('no_existing_file.txt', 'r');