1、 建立php快捷全局调用
	1）vi ~/.bash_profile 
		alias php=/usr/local/php7/bin/php

		source ~/.bash_profile
2、php编译安装坑
	1）需要gcc autoconfig
	2）查看php.ini文件 
		PHP -i|grep php.ini
	3) php源码包中有 php.ini-development, php.ini-production,如果没有找到配置，可以cp到指定目录

3、php扩展安装
	进入源码包
	phpize 安装扩展，并生成.configure文件
	.configure --with-php-config=/usr/local/php72/bin/php-config  使用不同版本的php编译

	修改配置文件
	extension=swoole [7.22没有加so]
	php -m 查看扩展

4、查看端口
	netstat -anp|grep 9501

	ps aft|grep tcp.php  // $serv->setting(['worker_num' => 4]) 查看启动了几个worker进程


5、 swoole 
	server端关闭后，客户端会断开连接，不过查看端口时，显示time_wait, 过一会才会关闭


6、 CLI获取输入变量
	
	fwrite(STDOUT, '请输入消息');
	$msg = trim(fgets(STDIN)); //获取刚输入的消息

7、 websocket
	全双工通信，服务器可以主动向客户端推送消息