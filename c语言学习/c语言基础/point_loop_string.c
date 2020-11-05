#include <stdio.h>

int main()
{
	char *p;
	char s[] = "Hello"; //此处注意用双引号
	//指针p指向字符串的首字符 'H'
	p = s; // 或者 p = &s[0]
	//遍历字符串
	for(;*p != '\0'; p++){ // 注意不要用双引号，否则会出错
		printf("%c\n", *p);
	}
	return 0;
}
