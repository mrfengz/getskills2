<?php

$path = '/Users/fz/Library/Application Support/微信web开发者工具/Default/.ide';
if (!file_exists($path)) {
    exit('请检查是否开启了开发者工具');
}

$projectPath = urlencode('/Users/fz/Documents/projects/rebuy-minip');
$port = file_get_contents($path);

$url = 'http://127.0.0.1:' . $port . '/open?projectPath=' . $projectPath;
shell_exec('/Applications/MAMP/Library/bin/curl ' . $url);
