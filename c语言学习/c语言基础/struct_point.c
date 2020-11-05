#include <stdio.h>

int main(int argc, const char * argv[]) 
{
	//定义一个结构体类型
	struct Student {
		char *name;
		int age;
	};
	
	//定义一个结构体变量
	struct Student stu = {"MJ", 27};
	//定义一个指向结构体变量的指针变量
	struct Student *p;
	
	//指向结构体变量
	p = &stu;
	
	//访问结构体成员的三种方式
	printf("方式1：name=%s,age=%d\n",stu.name, stu.age);
	printf("方式2：name=%s,age=%d\n",(*p).name, (*p).age);
	printf("方式3：name=%s,age=%d\n",p->name, p->age);
}
