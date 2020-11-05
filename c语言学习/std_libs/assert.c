// assert()  void assert(int expression) 允许诊断信息写入到标准错误文件中
// expression 可以是一个变量或任何C表达式，如果expression为true,assert()不执行任何动作；如果为false,assert()会在标准错误stderr上显示错误消息，并终止程序

#include <assert.h>
#include <stdio.h>

int main()
{
	int a;
	char str[50];
	
	printf("请输入与一个整数值：");
	scanf("%d", &a);
	assert(a >= 10);
	printf("输入的整数是: %d\n", a);

	printf("请输入字符串:");
	scanf("%s", &str);
	assert(str != NULL);
	printf("输入的字符串是： %s\n", str);
	return 0;
}

