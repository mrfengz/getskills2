PHP
	脚本解析器
	没有想Golang那样实现类http网络库，而是实现了FastCGI协议，配合web服务器实现对http请求的处理

	多进程
		nginx,fpm。
		主进程只负责管理子进程，网络事件由子进程处理

	多线程
		主线程监听、接收请求，然后交由子线程处理，memecached
		


FPM
	FPM(FastCGI Process Manager)是PHP 的 FastCGI运行模式的一个【进程管理器】
	FastCGI是web服务器(如Nginx/Apache)和处理程序之间的一种通信【协议】。
	
	基本实现
		fpm的实现就是创建一个master进程，在master进程中创建并监听socket，然后fork出多个子进程，这些子进程各自accept请求。

		master进程与worker进程之间不会直接通信，master通过共享内存获取worker进程的信息。通过发送信号决定是否关闭worker进程。

		worker进程启动后阻塞在accept上，有请求到达后开始请求出具，读取完后再返回，期间不再接受其他请求(子进程同时只能相应一个请求)。这与nginx的事件驱动不同，nginx子进程通过epoll管理套接字，如果一个请求数据还未发送完成，则会处理下一个请求，一个今晨会同时连接多个请求，非阻塞，只处理活跃的套接字。

		fpm可以同时监听多个端口，每个端口对应一个worker pool，每个pool下对应多个worker进程，类似于nginx的server概念。

	初始化

		1.注册 SAPI:将全局变量sapi_module设置为cgi_sapi_module

		2.执行php_module_startup()

		3.初始化 fpm_init()
			1) fpm_conf_init_main() 		# 解析php-fpm.conf，分配内存并保存到全局变量中
			2）fpm_scoreboard_init_main() 	# 记录worker进程运行信息的共享内存。按照worker pool的最大worker进程数分配，为每个worker pool分配一个fpm_scoreboard_s结构，pool下对应的每个worker进程分配一个fpm_scoreboard_proc_s结构
			3）fpm_signals_init_main() 		# 注册新号处理程序
			4）fpm_sockets_init_main() 		# 创建每个worker pool的socket套接字
			5）fpm_event_init_main() 		# 启动master的事件管理(管理IO，定时器)

		4.fpm_run() //下面是worker进程，master进程不会走到下边
			此环节将fork子进程，启动进程管理器。另外master进程将不再返回，只有各worker进程会返回
	
	请求处理
		fpm_run()执行后将fork出worker进程，worker进程返回main()中继续向下执行，后边就是worker进程不断accept请求，然后执行php脚本并返回。

		整体流程
			1）等待请求
				worker阻塞在fcgi_accept_request()等待请求
			2）解析请求
				fastcgi请求在到达被worker接收，然后开始接收并解析请求数据，知道request数据完全到达
			3）请求初始化
				执行php_request_startup(),此阶段会调用每个扩展的：PHP_RINIT_FUNCTION()
			4）编译执行
				由php_execute_script()完成PHP脚本的编译与执行
			5）关闭请求
				请求完成后执行php_request_shutdown()，此阶段会调用每个扩展的PHP_SHUTDOWN_FUNCTION(),然后进入步骤1）等待下一个请求

			worker进程处理到各个阶段时，会把当前阶段更新到fpm_scoreboard_proc_s->request_stage，master进程根据这个标识判断worker进程是否空闲

	进程管理
		1. static
			启动master时，按照pm.max_children配置fork出相应的worker进程，数量不变
		2. dynamaic 动态管理进程
			fpm启动时，按照pm.start_servers初始化一定数量的worker，运行期间master发现空闲worker数低于pm.max_spare_servers配置数(说明请求较多，worker处理不过来)，则会fork worker进程，超过则会杀掉一些worker，避免资源浪费。但是总数不会超过pm.max_children。
		3. ondemand 
			启动时不分配worker进程，有请求后再通知master进程fork worker进程。总的worker数不会超过pm.max_children。处理完成后worker进程不会立即退出，当空闲时间超过pm.process_idle_timeout后再退出


