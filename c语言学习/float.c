#include <stdio.h>
#include <float.h>

int main() {
	printf("Storage size for float is : %d \n", sizeof(float));
	printf("Mininum of float positive value: %E \n", FLT_MIN);
	printf("Maximun of float positive value: %E \n", FLT_MAX);
	printf("Precision value: %d \n", FLT_DIG);
}
