#include <stdio.h>

#define MAX(x,y) ((x) > (y) ? (x) : (y))

int main(void) {
	printf("Max between 20 and 10 is : %d\n", MAX(20,10));
	return 0;
}
