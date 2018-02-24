#include <stdio.h>

typedef struct MyPoint {
	float x;
	float y;
} Point;

int main()
{
	//定义结构体变量
	Point p;
	p.x = 10.0f;
	p.y = 20.5f;
	return 0;
}
