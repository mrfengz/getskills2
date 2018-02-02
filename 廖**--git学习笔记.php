<?php
/*
git config --global user.name "Your Name"		配置用户名称
git config --global user.email you@example.com  配置用户密码
 */
// 1 检查是否安装
	在命令行输入 git 
	没有的话自行百度安装

// 2 版本库
	可以理解成一个目录，所有文件都可以被git管理。git可以追踪修改、删除等，可以查看历史，可以还原

	mkdir gitlearn
	cd gitlearn
	下一步 
		git init [出现下面这句话，就表示成功了]，会在该目录下创建一个 .git目录，就是版本库
		Initialized empty Git repository in /Users/PHP-09/projects/git/agit/.git/

# ======== 时光穿梭 =========
// 3 版本回退
	git add readme.txt 	//添加到暂存区
	git commit -m '添加readme.txt' //从暂存区提交到仓库
	git status //查看是git的状态 
		// 如果显示 modified ，可以通过git diff readme.txt对比差异
	git log  //查看commit的记录，截止到当前版本的记录
		// 显示更加美观  git log --pretty=oneline
		/*
		commit_id 版本号
		5dde570e120c68727ac9ce12aea8f8d58508cb18 修改
		e848b26ee7277d22671b57cf790adf8fb3c6497e append readme.txt
		 */
	git reset //版本修改 回到过去，或者回到未来
		--hard HEAD^ HEAD代表当前版本，HEAD^上个版本，HEAD^^上两个版本，HEAD~100 前100个版本
		--hard 版本号 //不用写全
		git reset --hard HEAD^ //回到上个版本，readme没有新增的内容了，git log没有第二次提交的内容了	
	git reflog // 这个版本更齐全，即便你回退了，也能找到你回退之前的其他版本
		找到版本号，然后利用 git reset --hard 未来版本 就回到未来了
	// 撤销修改 git checkout其实是用版本库中的内容替换工作区中的文件
	1 git checkout -- readme.txt // 如果没有git add，则内容回到修改之前
	2 git reset HEAD readme.txt //从缓存区撤销(到工作区) 已经git add 之后
		git checkout --readme.txt 撤销修改内容

	// 删除文件
		git rm a.txt  //删除文件
		git commint -m 'remove a.txt' //提交删除

		如果只是git rm，然后发现删错了，可以用 git checkout -- a.txt

# ============ 远程仓库 ============
	// 添加远程仓库
		以github为例，先进入家目录，看看有没有.ssh目录，进入查看是否有id_rsa(私钥，不能泄露) 和 id_rsa.pub两个文件
		没有的话， 打开shell，创建ssh key 
			ssh-keygen -t rsa "youremail@example.com"
		然后去github上，account settings ，ssh keys 中复制id_rsa.pub中的内容到key中，可以添加多个
		
		主要思想是将本地仓库与git仓库同步，远程仓库可以备份，也可以与他人协作

		/* 先有本地库，后有远程库 */
		// 1 将本地仓库关联到远程仓库 orgin 远程库的名字，也可以修改成其他的
		// 如果本地库有文件，貌似会被清空掉
		// git remote add origin git@server-name:path/repo-name.git
		git remote add orgin git@github.com:mrfengz/getskills2
		
		// 2 把本地内容推送到远程库上 
		// 第一次推送master分支时，加上-u参数，git不但会把本地的master分支内容推送到远程新的master分支上，
		// 还会把本地分支和远程分支关联起来，以后的推送或者拉取时，就可以简化命令
		git push -u origin master

		// 3 如果以后再次本地推送，就可以使用git push origin master推送最新修改
		git push  origin master 

		/* 从零开始，先创建远程库 */
		从远程库clone到本地
		git clone git@github.com:somebody/gitskills.git 

# ========== 分支管理 =========== 
	// 1 创建分支
	git checkout -b dev //创建并切换分支 相当于后面两条命令的组合 git branch dev(创建分支)； git checkout dev(切换分支)
	// 2 查看当前分支
	git branch *表示当前分支
	// 3 创建文件并提交分支
	和正常的提交一样操作 
	git add filename.ext 
	git commit -m 'comment'

	// 4 切换分支
	git checkout master 
	// 5 合并分支 需要先切换到主分支上，是主分支成为当前分支
	git merge dev 合并dev分支到当前分支
	// 6 删除分支
	git branch -d dev

	/* 二 冲突 */

	// 1 创建分支
	git checkout -b feature1 
	// 2 修改文件，commit到本地仓库
	// 3 切换分支
	git checkout master
	// 4 修改同一个文件，然后提交
	// 5 将feature1与master分支合并
	git merge feature1 
	git log --graph --pretty=oneline --abbrev-commit //查看图形化的分支
	// 6 解决冲突 可以使用git status查看 手动修改文件
	// 7 解决冲突后重新提交
	// 8 删除分支
	git branch -d feature1 

	/* 三 分支管理策略 */

	通常合并分支时，如果可能，git会使用fast forward模式，将两个分支指向同一个分支的位置。
	如果删除分支后，会丢掉分支信息

	如果要强制禁用fast forward模式，git就会在merge时，生成一个新的commit，这样从分支历史信息就可以看出分支信息
	使用参数 --no-ff
	git merge --no-ff -m 'comment' dev //不使用fast forward 合并分支，会创建一个新的commit

	一般都是有多条线 
	第一条线是master主线，只发布稳定的产品
	第二条线是dev线，大家的开发都在这里
	其他线是从dev分支中，自己创建的分支，开发新功能

	/* 四 bug分支 */

	// 1 冻结当前工作区和暂存区中的内容
	手头的工作还没有做完，然而有一个bug急需你马上去修改，怎么办，当前的又不能提交
	答：可以git 的 stash功能啊
	git stash //Saved working directory and index state WIP on master: 保存工作和和暂存区的内容
	// 2 解决bug
	然后你可以创建一个issue-001分支了，然后等你修改完成之后，合并到branch分支，删除这个bug分支就可以了
	// 3 解冻之前的工作区和暂存区
	查看stash列表
	git stash list //stash@{0}: WIP on master: 49fffbd merge with no-ff
	恢复stash内容
	1） git stash apply 恢复但是不删除； git stash drop 删除
	2） git stash pop 	恢复并删除stash内容

	指定恢复的版本
		git stash apply stash@{0}

	/* 五 feature分支 */

	有个新功能，要添加进去，创建了一个feature分支，开发完成后，你被告知要等几天
	然后经预算这个可能会造成一些损失，决定撤销该分支
	git checkout -b feature-vulcan 
	git add feature-vulcan.py 
	git commit -m '新开发功能'
	该合并了，但是忽然决定，该功能对经济效益促进不大，直接删除分支
	// git checkout dev 
	git branch -d feature-vulcan //删除分支
	在当前分支中删除时报错 error: Cannot delete the branch 'fea-v' which you are currently on.
	// 切换到dev分支
	git checkout dev
	// 再次尝试删除
	git branch -d feature-vulcan 
		// 没有合并到其他分支，需要使用 —D参数强删
		error: The branch 'fea-v' is not fully merged.
		If you are sure you want to delete it, run 'git branch -D fea-v'.
	// 强制删除
	git branch -D feature-vulcan 	

	/* 六 多人协作 */

	// 查看远程仓库信息
	git remote // 显示仓库名字
	git remote -v 
		origin	git@github.com:mrfengz/getskills2.git (fetch)
		origin	git@github.com:mrfengz/getskills2.git (push)

	// 推送分支
		git push 远程仓库名字 本地分支名字
		git push origin master //将本地master分支提交到远程的master分支
		git push origin dev    //将本地的dev分支提交到远程的dev分支

# =========== 创建标签 =============== 
	切换到需要打标签的分支上
	git branch //查看分支列表
	git checkout master //切换到要打标签的分支上
	// 标签默认是打在最近一次的commit上的
	git tag v1.0 //打标签 git tag <tag name>
	git tag //查看所有标签 

	// 对历史commit打标签
	git log --pretty=oneline --abbrev-commit //查看commit
	git tag v0.9 commit_id //  git tag v0.05 70b4663
	git tag //查看列表
	git show bg001 //查看bg001 tag的详情
	// 给标签添加说明
	git tag -a v0.01 -m "initial" 5d28f76
	git show v0.01 

	/* 标签操作 */
	// 1 删除标签
	git tag -d tagname // git tag -d v0.01

	// 2 推送到远程 单个标签
	git push origin <tagname> 

	// 3 一次性推送所有标签
	git push origin --tags

	// 4 删除远程标签
	先删除本地标签
	git tag -d v0.05
	删除远程标签
	git push origin :refs/tag/v0.05 //提交时，这个分支要在远程仓库中存在


# ========= 其他操作 ==========
// 忽略特殊文件
	在目录中创建一个 .gitignore文件
	然后指定不更新的文件 .*代表所有的.开头文件

	需要先更新.gitignore文件
	强制更新忽略的文件
	git add -f 忽略文件

	查看帮助
	git add --help



