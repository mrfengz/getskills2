安装
	wget 压缩包地址
	tar zxf 。。。
	cd 。。
	./configure --prefix=/usr/local/nginx

	# 依赖pcre
	yum install pcre pcre-devel

	# 端口被占用
	netstat -antp|grep 80 
	关闭对应的服务