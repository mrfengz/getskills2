#include <stdio.h>

int main() {
	int var = 20; //实际变量的声明
	int *ip;	//指针变量的声明
	
	ip = &var; // 在指针变量中存储var的地址
	printf("Address of var variable is: %x\n", &var);
	printf("Address of var variable is: %x\n", ip);//使用指针变量中存储的地址
	printf("Value of *ip is: %d\n", *ip);
	return 0;
}
