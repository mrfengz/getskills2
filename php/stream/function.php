<?php
echo '<pre>';
//支持的wrapper
print_r(stream_get_wrappers());

//获取处理数据的filter
print_r(stream_get_filters());

$content = file_get_contents('../array.php'); // == file://../array.php
//schema://target
//ftp:  ftp://user:pass@ftp.example.com/a.txt
//https:  https://exmaple.com/hello.php

print_r($content);


//-----------
//write data to a compressed file
$fp = fopen("compress.zlib://foo-bar.txt.gz", 'wb');
if (!$fp) die("Unalbe to open file.");


fwrite($fp, "this is a test \n");

fclose($fp);


//-----------
// make a post request to https server
$sock = fsocketopen("ssl://secure.example.com", 443, $errno, $errstr, 30);
if (!$sock) die("$errstr {$errno}\n");

$data= "foo=".urlencode('value for foo'). "&bar=" . urlencode("var for bar");

fwrite($sock, "POST /form_action.php HTTP/1.0\r\n");
fwrite($sock, "Host: secure.example.com\r\n");
fwrite($sock, "Content-Type: application/x-www-form-urlencoded\r\n");
fwrite($sock, "Content-Length: ". strlen($data)."\r\n");
fwrite($sock, "Accept: */*\r\n");
fwrite($sock, "\r\n"); //trim($data) --> 0

fwrite($sock, $data);

$headers = "";
while($str = trim(fgets($socket, 4096))) {
    $headers .= "$str\n";
}

echo "\n";

$body = "";
while(!feof($sock)){
    $body .= fgets($sock, 4096);
}

fclose($sock);

echo $header.PHP_EOL;
echo $body.PHP_EOL;
