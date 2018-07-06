composer install # 如果有composer.lock,直接安装，否则从composer.json安装最新扩展

composer update # 从composer.json安装最新扩展包和依赖

composer update new/package # 添加new/package,可以指定版本 如composer update new/package ~3.5

一般部署程序的操作：
	1.创建composer.json,并添加依赖到扩展包
	2.运行composer install,安装扩展并生成composer.lock
	3.提交composer.lock到代码版本库中
	4.克隆项目到生产环境，根目录下直接运行 composer install 从 composer.lock中安装指定版本的扩展包及其依赖

composer clear-cache/clearcache # 从缓存目录中清空下载的缓存包文件。 清除下载缓存的依赖包，再次安装或者更新时会从本地直接读取缓存。

archive (不会下载此包的依赖)
	composer archive abei2017/yii2-emoji --format=zip/tar --dir ./zip # 从远程下载包，然后打包。
	format 有zip/tar格式，推荐使用zip格式，默认为tar格式
	