#include <stdio.h>
//定义一个结构体
struct Student {
	int age;
};

void test(struct Student stu) {
	printf("修改前的形参：%d\n", stu.age);
	//修改形参
	stu.age = 10;
	printf("修改后的形参：%d\n", stu.age);
}

int main(int argc, const char * argv[])
{
	struct Student stu = {30};
	printf("修改前的实参：%d\n", stu.age);
	//调用test()函数
	test(stu);
	printf("修改后的实参：%d", stu.age);
	return 0;
}
