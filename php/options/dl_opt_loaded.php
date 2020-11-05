<?php
if(!extension_loaded('gd')) {
    if(substr(PHP_OS,0,3) == 'WIN') {
        dl('gd.dll');
    } else {
        dl('gd.so');
    }
}