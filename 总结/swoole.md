修改内核参数
	vim /etc/sysctl.conf

	net.unix.max_dgram_qlen = 100 	swoole使用unix socket dgram来做进程间通信，如果请求量很大，需要调整此参数。系统默认为10，可以设置为100或者更大。

	net.core.wmem_max 				修改此参数增加socket缓存区的内存大小
	
	net.ipv4.tcp_tw_reuse 			是否socket reuse，此函数的作用是Server重启时可以快速重新使用监听的端口。如果没有设置此参数，会导致server重启时发生端口未及时释放而启动失败

	net.ipv4.tcp_tw_recycle 		使用socket快速回收，短连接Server需要开启此参数。此参数表示开启TCP连接中TIME-WAIT sockets的快速回收，Linux系统中默认为0，表示关闭。打开此参数可能会造成NAT用户连接不稳定，请谨慎测试后再开启。