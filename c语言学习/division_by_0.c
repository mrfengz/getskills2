#include <stdio.h>
#include <stdlib.h>

main()
{
	int dividend = 20;
	int divisor = 10;
	int quotient;

	if(divisor == 0) {
		fprintf(stderr, "Division by zero! exiting...\n");
		exit(-1);
	} else {
		quotient = dividend /divisor;
		fprintf(stderr,"Value of quotient: %d\n", quotient);
		exit(0);
	}
}
