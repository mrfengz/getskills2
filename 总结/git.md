terms:
	repository
		包含着commit的集合，项目working tree带有日期标记。还定义了一个HEAD，指明了当前working tree 源于哪个branch或者commit。还包括一些列分支和标记
	the index
		你对代码的更改不是直接提交到repository,而是先提交到 the index(commit前存储的地方),也有人叫做 stage area 暂存区
	working tree
		与一个repository关联的本地文件系统中的目录，它有一个.git目录
	commit 
		commit是对 working的一个快照，HEAD在你提交之后，会变成这次commit的parent，从而形成一个 版本历史轨迹线
	branch 
		是对某个commit的引用。不是很理解，待补充
	tag
		与branch类似，也是一个commit的别名
	master

	HEAD
		被repository用来checkout的内容版本。
		如果检出的是一个分支，HEAD就指向分支，下一次commit时，内容会被更新到对应的分支中
		如果你检出一个特定的commit，那么HEAD仅仅进行引用。也称为引用分离。


Reposity ------git -checkout -------   working tree
		|						|
git commit |				| git -add
				|		|
				    |
				  index

----------- Repository ----------

	类似于文件系统。文件内容通过blob标识，同样的内容的blob标识是一样的，不同的文件含有同样标识时，相当于一个链接。
	blob包含在tree中，tree会记录元数据。比如同样的内容，一个是去年创建的文件，一个是昨天创建的，只是名字不一样。这在文件系统中，就是两个文件。

----------- Blob二进制大文件 ----------
	mkdir sample
	cd sample
	echo 'Hello, world!' > greeting
	git hash-object greeting // 获取greeting文件内容的hash id
	不同的文件名字，内容一样时，hash id一样，说明是基于内容的hash

	git cat-file -t hash id(或前几个字符) //blob 获取文件类型
	git cat0file blob hashId(或前几个字符) //显示内容 Hello, world!

----------- tree ----------
	Blob只是二进制文件，没有名称，所以被关联到tree中

	git ls-tree HEAD //查看最近一次commit所在的树
	output: 100644 blob af5626b4a114abcb82d63db7c8082c3c4756e51b greeting

	git rev-parse HEAD //将head别名解析到它commit时的引用
	git cat-file -t HEAD //获取类型 为commit

	git cat-file commit HEAD //查看树信息
	tree 2616075cb4eb347813ff96118b4c2b7f0b2def6c
	author zhu.feng <fengzhu@x-ui.com> 1523944227 +0800
	committer zhu.feng <fengzhu@x-ui.com> 1523944227 +0800

	Add my greeting

------------ how trees are made ---------
新建目录 echo 'hello world!' > greeting
	git init
	git add greeting //此时会生成一个object

git log //会报错，因为没有commit
git ls-files --stage  //list the blob referenced by the index 会显示一个hashid :100644 af5626b4a114abcb82d63db7c8082c3c4756e51b 0	greeting

git write-tree //生成一个tree 把之前生成的index记录添加到一个tree中.此时还没有commit object,这个命令是把index区的内容塞到即将commit的书中


---------- commit ----------
	git branch -v  see all the top-level,referenced commits 
	#branch is nothing more than a named reference to a commit,just like tags, which can have description

	git reset --hard 5f1bc85 # reset the head of working tree to a specified commit
	(相当于擦除所有自那个commit之后的所有的更改，与git checkout 5f1bc85功能一样)


	
	

----------- 分支 -----------
git branch branchname		# 创建分支
git checkout branchname		# 切换到分支
git checkout -b brance		# 新建分支别切换到该分支
git branch -d branchname 	# 删除分支
git merge branchname 		# 合并分支

git branch 					# 显示分支列表

不同的分支修改同一行时，它会报冲突，需要手工修改。如果是重命名文件，git 可以检测到

-------- git log -------
git log 					# 查看提交快照的信息。所有的历史构成了一棵树，构成一个上下文环境
git log --online			# 查看紧凑显示的记录信息
git log --online --graph	# 显示拓扑图
git log --oneline branchname # 查看一个分支从建立起的可追溯的记录
git log --oneline branchname ^master # 看指定分支中有，而主分支中没有的，也就是看哪些是新增的快照单没有合并到主分支

	--- 其他命令 ---
	git log branchA ^branchB		# 比较两个分支的区别
	git log --author=				# 只查看某个作者的提交
		git log --author=Linus --oneline -5

	git log --since --before		# 根据日期过滤提交记录
		git log --before={3.weeks.age} --after={2018-04-20} --no-merges

	git log --grep 					# 根据提交注释过滤提交记录
		git log --grep=PHP --no-merges	

------- git diff --------
git diff [version/tag] 		# 查看自某个发布后的修改
git diff v039 --stat 
git diff branchA branchB --stat	# 显示两个分支之间的所有改动
git diff branchA...branchB --stat # 显示branchB中自两次分支开始有差别时，该分支的变动 	


------ git tag ---------
git tag 				# 给历史记录中的某个重要点打一个标签
git tag -a v1.0 		# 给最新的一次快照提交打上v1.0的标签 -a选项让你添加一个注释

git log --online --graph --decorate #查看带注释的标签

------ git 远程仓库 -------
git fetch 	# 更新你的项目
git push 	# 分享你的改动
git remote	# 管理远程仓库

git remote 		# 列出远端别名
	如果是克隆的远程项目，会将远程项目别名为 origin
	git remote -v 
		origin	git@github.com:github/git-reference.git (fetch) 获取的链接
		origin	git@github.com:github/git-reference.git (push)  推送的链接

git fetch 		# 获取远端仓库有的，你没用的文件，更新本地仓库。同时也会获取远端的分支信息，除不能切换到远端新增分支之外，其他的无太大区别，可以进行合并。
	git fetch remote-alias # 更新git仓库的某个远端。 然后通过git merge alias||branch将服务器的更新合并到当前分支

	git fetch --all 		# 告诉git 同步所有的	远端仓库

git pull 		# 相当于git fetch 之后紧接着 git merge



git push 		# 推送你的新分支与数据到某个远端仓库
	git push github master # 将你的master分支提交到远端的github仓库，分支为master





--------- git 命令---------
git init
git clone git:... url #从远程克隆代码库并将head指向当前master分支

git add 	# 添加需要追踪的文件和待提交的文件  add . 会递归地将所有的目录文件添加
git status	# 查看(上次提交之后有什么被修改或者临时提交)状态  -S 输出简短信息
	git status -s 		#输出简短信息
git diff	# 已临时提交或者已修改但未提交的改动
	git diff 无参数  		# 查看上次快照(git commit之后未缓存的)差异
	git diff --cached 	# 显示哪些已经写入缓存了。(也就是已经git add 之后的变化)
	git diff HEAD 		# 查看上次快照到现在的所有的已缓存和未缓存的所有文件改动
	git diff --stat 	# 查看摘要，而不是所有的差异信息，可以--cached等并列使用
git commit	# 提交到快照记录
	会带上你的 user.name 和 user.email
	git commit -a 		#将已经存在的文件，先git add 再 git commit，是一种简略写法。但是新增文件仍然要用git add方法添加

git reset
	git reset HEAD -- file #取消缓存中已缓存的内容

	git config --global alias.unstage "reset HEAD" 配置一个别名，可以使用下面的操作
	git unstage -- file

git rm 将文件从缓存区移除
	git rm 			# 与git reset HEAD 有区别的.取消时将缓存区恢复为修改之前的样子。git rm 是将文件彻底从缓存区删除，它不在下一个提交快照之内，从而有效删除
	git rm file 	# 将文件从缓存区和硬盘中删除 
	git rm --cached # 在目录中保留该文件




注意：
 1） git add newfile # 添加到index区，没有commit
 	然后又修改，查看 git status， 显示AM 状态，此时如果git commit 提交，则不会提交第二次修改后的内容，如果要提交，需要先git add之后才可以



<!-- 实战 -->

本地建立目录
mkdir swoole
	cd swoole
	git init

去github上创建目录
	勾选创建readme
	
将本地与github远程仓库合并
	git remote add origin git@github.com:mrfengz/swoole.git
	git pull origin master //拉取并合并远程仓库内容到本地
	git pull origin master --allow-unrelated-histories //如果提示出错的话 好像是本地有unrelated histories
	

添加忽略文件
	使用编辑器或者其他系统时，有时候会有一些产生的无用文件，需要排除
	创建.gitignore文件到git目录中
	添加要忽略的文件
		.gitignore
		.idea/
		.DS_STORE

		规则
		dir/ 	# 忽略目录
		*.[oa] 	# 忽略以.o 或者 .a结尾的文件
		!test.a # 不忽略test.a文件 

	可以使用git status查看工作区是否干净

	git add -f Add.a 强制添加文件

	git check-ignore 检查哪条规则错误

	如果提交了不应提交的文件到服务器，可以使用以下方法删除远程仓库中文件
	git rm --cached path/to/file
	git commit -m 'delete file';
	git push -u origin master


===== 更新远程代码到本地仓库 ====
git fetch origin branch1
git fetch origin branch1:branch2 如果远程分支不存在，报错，如存在，本地branch2不存在，会创建一个，但是	不会切换到该分支

git fetch origin master 从远程origin仓库的master分支下载代码到本地的master分支
git log -p master origin/master 比较本地仓库与远程仓库的区别
git merge origin/master //把远程代码合并到本地仓库



git config --global core.autocrlf false 忽略不同系统的文件结束符


-----------------------
git pull upstream develop 拉取远程主机 upstream develop分支到当前分支中
git pull upstream develop:feat/barcode 拉取远程的develop并合并到feat/barcode分支中

git rebase upstream/develop develop 将分叉合并为一条主线
git rebase --continue
git rebase --abort


//查看与远程分支的差别
 git log feat/barcode..upstream/develop		显示远程有而本地没有的commit
 		 local_branch..remote/branch  

git diff --stat feat/barcode upstream/develop #统计本地与远程之间的文件改动


5月18号
810
815 
816
840

3de2c288

############## git ##############
## 仓库初始化的两种方式
	1. 从服务器克隆一份
	2. 将已有项目目录导入git中
		git clone url targetName

