#include <stdio.h>

int sumAndMinus(int a, int b, int *minus)
{
	//计算两者的差，并赋值给差值的地址变量
	*minus = a - b;
	return a + b;
}

int main()
{
	int a = 10, b = 5;
	int sum, minus;
	//调用函数
	sum = sumAndMinus(a, b, &minus);
	// 打印和	
	printf("%d+%d=%d\n", a, b, sum);
	// 打印差	
	printf("%d-%d=%d\n", a, b, minus);
	return 0;
}
