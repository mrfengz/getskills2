// 函数指针

#include <stdio.h>

//定义一个sum函数，计算a跟b的和
int sum(int a, int b)
{
	int c = a + b;
	printf("%d+%d=%d", a, b, c);
	return c;
}

int main()
{
	//定义一个指向sum函数的指针变量
	int (*p)(int, int) = sum;

	//利用指针变量p调用函数
	(*p)(4,5);
	return 0;
}
