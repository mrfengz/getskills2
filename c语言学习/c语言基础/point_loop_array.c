#include <stdio.h>

int main()
{
	int a[4] = {1,3,4,6};
	int i;
	// 常规循环
	for(i=0; i<4; i++){
		printf("a[%d] = %d\n", i, a[i]);
	}
	// 指针循环
	int b[4] = {1,3,4,6};
	int *p = b;
	int j;
	for(j=0; j<4; j++){
		int value = *(p + j);
		printf("b[%d] = %d\n", j, value);
	}
}
