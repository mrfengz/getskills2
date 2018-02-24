#include <stdio.h>

typedef int Integer;
typedef unsigned int uInteger;
typedef float Float;

int main(int argc,const char * argv[])
{
	Integer i = -10;
	uInteger ui = 11;

	Float f = 12.39f;
	printf("%d %d %.2f", i, ui, f);
	return 0;
}
