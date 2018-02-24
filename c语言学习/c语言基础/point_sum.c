#include <stdio.h>

void swap(char *v1, char *v2)
{
	//中间变量
	char temp;
	//取出v2指向的变量
	temp = *v2;
	//取出v2的值，然后赋值给v1
	*v2 = *v1;
	//赋值给*v2
	*v1 = temp;
}

int main()
{
	char a = 10, b = 9;
	printf("交换前a=%d, b=%d\n", a, b);
	swap(&a, &b);
	printf("交换后a=%d, b=%d\n",a,b);
	return 0;
}
