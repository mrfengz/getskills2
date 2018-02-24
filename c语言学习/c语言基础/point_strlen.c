#include <stdio.h>
#include <string.h> //必须引入字符串函数定义文件
int main()
{
	//定义一个字符串，用指针s指向这个字符串
	char *s = "msj";
	//使用strlen()检测字符串长度
	int len = strlen(s);
	printf("字符串长度：%d\n", len);
	return 0;
}
