#include <stdio.h>

typedef char *String;

int main()
{
	// 相当于 char *str = "This is a string";
	String str = "This is a string";
	printf("%s", str);
	return 0;
}
