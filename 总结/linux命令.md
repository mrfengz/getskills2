-------- 用户管理 ---------
useradd admin  		#添加一个管理员
passwd 用户名 		#修改密码
userdel 用户名		#删除用户
userdel -r 用户名 	#删除用户名及用户主目录

init 
	运行级别 3,5常用
		0		关机
		1 		单用户
		2 		多用户状态没有网络服务
		3 		多用户状态有网络服务
		4 		系统未使用保留用户
		5		图形界面
		6		系统重启

	/etc/inittab 中设置该参数 system V
	(init的版本)
		system V
		systemd
		upstart

	logout

	reboot


登录后默认进入用户家目录 /home/admin/中

touch file			#创建文件
cp file1 file2		# copy
	cp file1 file2 dir1 # 将file* copy到 dir1中

cp -r dir1 path/to/dir2 	# dir1 copy到dir2

mv 

more 		# 
less		# 显示一屏的内容
grep		# 查找内容
| 			# 管道命令   把上一个命令的结果，交给|后面命令的参数或者输入

帮助
	man 命令
	命令 -h
	命令 --help

查找文件
	find dir -name  filename

重定向
	ls -l dir1 > filename	# 内容重定向到文件中，不存在就新建，存在内容清空后插入
	ls -la dir1 >> filename # 追加到filename中


用户组权限
	目录 
		读 列出目录
		可执行 可以进入目录

	groupadd policeman 		# 添加组
	vi /etc/group 			# 查看所有组的信息
	useradd -g 组名 用户名 	# 创建用户，并将用户分配到指定组
	cat /etc/passwd 		# 查看所有用户
	
检查和修复文件系统
	fsck /dev/sbd1
	debugfs

free -h 	# 查看交换空间使用情况

使用磁盘分区或者文件作为交换空间
	文件作为交换空间
	dd if=/dev/zero of=swap_file bs=1024k count=num_db(文件大小，单位M)
	mkswap swap_file

swapoff 命令删除交换分区或者交换文件
	swapon swap_file

