#include <stdio.h>

int main()
{
	enum Season {spring, summer, autumn, winter} s;
	s = spring; //等价于s = 0;
	//s = 3; //等价于s = winter
	for(; s <= winter; s++) {
		printf("枚举元素：%d\n", s);
	}
	return 0;
}
