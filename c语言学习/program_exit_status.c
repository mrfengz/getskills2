#include <stdio.h>
#include <stdlib.h>

main() 
{
	int dividend = 20;
	int divisor = 5;
	int quotient;

	quotient = dividend / divisor;	
	if(divisor == 0) {
		fprintf(stderr, "Division by zero! Exiting ... \n");
		exit(EXIT_FAILURE);	
	}else {
		fprintf(stderr, "value of quotient : %d\n", quotient);
		exit(EXIT_SUCCESS);
	}
}
