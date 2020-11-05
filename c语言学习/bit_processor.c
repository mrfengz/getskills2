#include <stdio.h>

main() {
	unsigned int a = 60; // 60 = 0011 1100 
	unsigned int b = 13; // 13 = 0000 1101
	int c = 0;
	c = a & b;			 // 12 = 0000 1100 
	printf("60 & 13 is :%d\n", c);

	c = a | b;			 // 61 = 0011 1101
	printf("60 | 13 is :%d\n", c);

	c = a ^ b;			 // 49 = 0011 0001 
	printf("60 ^ 13 is :%d\n", c);

	c = ~a;				 // -61 = 1100 0011
	printf("~60 is : %d\n", c);

	c = a << 2;			 // 240 = 1111 0000
	printf("60 << 2 is :%d\n", c);

	c = a >> 2;			 // 15 = 0000 1111
	printf("60 >> 2 is : %d\n",c);
}
