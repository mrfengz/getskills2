<?php
$data=  $_POST;
$dir = '../uploads/';
$ext = ltrim(strchr($data['type'], '/'), '/');
$filename = uniqid().'.'.$ext;

if (!is_dir($dir))
    mkdir($dir, 0755, true);

$content =  $file_base64 = preg_replace('/data:.*;base64,/i', '', $data['data']);
$res = file_put_contents($dir.$filename, base64_decode($content), true);
echo json_encode(['code' => '0', 'msg' => 'ok', 'data' => ['url' => str_replace('..', '', $dir.$filename)]]);
