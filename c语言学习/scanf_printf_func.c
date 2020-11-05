#include <stdio.h>

int main()
{
	char str[100];
	int i;
	
	printf("Please Enter a value:");
	scanf("%s %d", str, &i);
	
	printf("\n You entered : %s %d", str, i);
	return 0;
}
