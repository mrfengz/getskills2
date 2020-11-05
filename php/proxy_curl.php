<?php
//如果需要转发微信连接到本地 我还不是很确定
//设置的是
/*
 * 类型       侦听端口        目标          说明
 * Local    80(localhsot)   47.93.15.25
 * Remote   7080(localhost) localhost:80
 * Dynamic  1080(localhost)
 */

$url = 'http://www.threewalker.top/getPost.php';
$proxy = 'socks5://127.0.0.1:1080'; //与xshell连接属性中的 dynamic sock4/5中设置的端口号一致
//$proxyauth = 'user:password';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);         // URL for CURL call
curl_setopt($ch, CURLOPT_PROXY, $proxy);     // PROXY details with port
//curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);   // Use if proxy have username and password
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5); // If expected to call with specific PROXY type
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  // If url has redirects then go to the final redirected URL.
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);  // Do not outputting it out directly on screen.
curl_setopt($ch, CURLOPT_HEADER, 1);   // If you want Header information of response else make 0
$curl_scraped_page = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);

var_dump($info,  $curl_scraped_page);