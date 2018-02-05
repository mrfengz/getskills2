#include <stdio.h>
#include <errno.h>
#include <string.h>

extern int errno;

int main() 
{
	FILE *fp;
	int errnum;
	fp = fopen("unexists.txt", "rb");
	if(fp == NULL) {
		errnum = errno;
		fprintf(stderr, "value of errno: %d\n", errno);
		perror("Error printed by perror()\n");
		fprintf(stderr, "Error opening file : %s\n",strerror(errnum));
	} else {
		fclose(fp);
	}
	return 0;
}
