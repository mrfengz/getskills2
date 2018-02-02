#include <stdio.h>

main() {
	FILE *fp;

	fp = fopen("./tmp.txt", "w+");
	fprintf(fp, "This is testing for fprintf ...\n");
	fputs("This is testing for puts ...\n",fp);
	fclose(fp);
}
