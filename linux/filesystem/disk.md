## 文件系统
    ext2/ext3/ext4
    磁盘(/dev/sda)---主分区(/dev/sda1-4)---扩展分区---逻辑分区(/dev/sda5-8)
    目录
    文件： inode(索引节点)/dentry(目录项)

## 1.查看磁盘整体信息
    fdisk -l
    显示磁盘整体和分区信息
    
## 2. 查看与磁盘文件相关信息
    df -lh
