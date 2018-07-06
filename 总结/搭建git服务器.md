## 配置git服务器
  2018-06-07
1. 安装 yum install -y git
	检查版本 git --version

2. 创建git用户和用户组
	groupadd git
	adduser git -g git

3. 选择一个仓库目录
	cd /srv
	创建一个仓库目录
	mkdir wechat.git
	git init --bare  # 初始化为空目录

	git -R git:git wechat.git  //更改所有者和所属组

4. ssh登录
	在本地使用 ssh-genkey生成公钥和秘钥，然后
	cat ~/.ssh/id_rsa.pub
	复制内容

	在/home/git/.ssh/中
	echo '复制的内容' > authorized_keys
	
	重启服务端 service sshd restart

5. 本地建立仓库
	本地目录
	git remote rm origin # 删除以前关联的远程分支
	git remote add origin git@ip:/path/to/gitrepo

	git push -u origin master

6. 配置钩子更新到项目目录
	cd /srv/wechat.git/hooks
	cp post-receive.sample post-receive

	shift+G # 调到文件结尾
	o  		# 新增一行
	git --work-tree=/www/ciwechat checkout -f  //跟新到指定的目录中

	填坑说明：
		错误信息：创建ciwechat后，本地仓库commit后出错。 cannot create applicaiton ...
		usermod git -G root 	# 将git添加到root组
		chmod g+r /www/ciwechat # 对该文件有读写执行权

		再次修改后，就可以创建项目了。

	如果项目已经在运行了
		1. tar -zcf project.tar project_dir  # 压缩项目目录
		2. cd /srv/
			mkdir project.git
			cd project.git
			git init --bare # 初始化项目目录

			cd project.git/hookes
			mv post-receive.sample post-receive
			echo 'git --work-tree=/path/to/project checkout -f' > post-receive

			chown -R git:git /srv/project.git
		3. scp username@server:/path/to/project.tar ~/local_dir
		4. tar -zxf ~/local_dir/project.tar 	# 解压
		5. git add .
			git commit -m '初始化项目目录'
			git remote add origin git@server:/srv/project.git

			git push -u origin master





