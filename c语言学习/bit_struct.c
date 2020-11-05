#include <stdio.h>

main() 
{
	struct bs{
		unsigned a:1;
		unsigned b:3;
		unsigned c:4;
	}bit, *pbit;
	// 注意不要超过存储的范围了
	bit.a = 1;
	bit.b = 7;
	bit.c = 15;

	printf("%d, %d, %d \n", bit.a,bit.b,bit.c);
	pbit = &bit; // 把位域变量 bit 的地址给指针变量pbit
	pbit->a = 0;
	pbit->b &= 3; //复合运算，按位&
	pbit->c |= 1;//复合运算，按位|
	printf("%d, %d, %d\n", pbit->a,pbit->b,pbit->c);
}
