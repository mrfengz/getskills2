#### 1 基础知识
	C编译器
		源文件：源文件中的代码是人类可读的代码，也就是自己或别人写的
		编译：将人类可读的语言转换为及其语言，让CPU按照给定指令运行程序。
		编译后的源代码成为可执行程序

	C程序结构
		主要有以下几部分
			预处理器指令	如 #include <stdio.h>
			函数
			变量
			语句 & 表达式
			注释			/* 我是注释 */
	编译 & 执行C程序
		编写完文件后，编译(得到a.out)，然后运行编译后的文件
		gcc hello.c #编译
		./a.out 	#运行编译后文件

	C的令牌(Tokens)
		C程序由公众令牌组成，可以是关键字、标识符、常量、字符串值、或者一个符号
		printf("Hello world! \n"); //5个令牌

	标识符 
		用来标识函数、变量或任何其他用户自定义项目的名称，A-z或者以_开哦图，后跟数字字母和下划线
		不允许出现标点字符
		区分大小写

	关键字
		也叫保留字。不能作为变量、常量名或者其他标识符

	数据类型
		1) 基本类型：算术类型，包括整型和浮点类型
		2) 枚举类型：也算是算术类型，用来定义在程序中只能赋予其一定的离散整数值的变量
		3) void类型：表明没有可用的值
		4) 派生类型：包括指针类型、数组类型、结构类型、共用体类型和函数类型
		聚类类型：数组类型和结构类型统称为聚合类型。
		函数的类型指的是函数返回值的类型
		void类型适用情况
			函数返回为空	不返回值的函数的返回类型为空， 如 void exit(int status)
			函数参数为空	不接受参数的函数 int rand(void)
			指针指向void 类型为void * 的指针代表对象的地址，而不是类型。例如内存分配函数 *void malloc(size_t size);返回指向void的指针，可以转换为任意类型

		范围及存储字节大小
			获取占用字节范围大小 sizeof() 如int,float
			获取float的最小值 FLT_MIN 需要引入<float.h>
			获取float的最大值 FLT_MIN
			获取float的精确度 FLT_DIG

	C变量
		变量只不过是程序可操作的存储区的名称。C中每个变量都有指定的类型，类型决定了变量存储的大小和布局
		基本变量类型：
			char int float double void
		变量定义
			告诉编译器在何处创建变量的存储，以及如何创建变量的存储。
			变量定义需要制定一个数据类型，并包含了该类型的一个或多个变量列表
			type var_list; //变量定义
			示例：
				int i,j,k;
				double d;
			type var_name = value; //定义并初始化
				extern int d = 3,f = 5;
				
			注意：不带初始化的定义，如果带有静态存储持续时间的变量会被隐式初始化为NULL(所有字节都是0),其他所有变量的初始值是未定义的

		变量声明
			向编译器保证变量以给定的类型和名称存在。这样编译器在不需要知道变量完整细节的情况下也能进一步编译。变量声明只在编译时有意义，在程序连接时，编译器需要实际的变量声明

			extern 关键字在任何一个地方声明变量。虽然可以在程序中多次声明一个变量，不过变量只能在某个文件、函数或者代码块中被定义一次。
			在函数声明时，提供一个函数名，而函数的实际定义可以在任何地方进行。
			
			#include <stdio.h>
			// 变量声明
			extern int a,b;
			extern int c;
			extern float f;

			int main(){
				/* 定义变量 */
				int a,b;
				int c;
				float f;

				/* 实际初始化 */
				a = 10;
				b = 20;

				c = a + b;
				printf("value of c: %d", c);

				f = 70.0/3.0;
				printf("value of f: %f ", f);
				return 0;
			}
			//编译后运行
				value of c : 30
				value of f : 23.333334
			
			---- 示例2 -----
			// 函数声明
			int func();

			int main() {
				// 函数调用
				int i = func();
			}

			// 函数定义
			int func() {
				return 0;
			}

		左值和右值
			左值指向内存位置的表达式，可以出现在等号的左侧和右侧，例如变量。
			右值指的是存储在地址中某些地址的【值】，不能对右值赋值。
	C常量
		常量是固定值，在程序执行期间不会改变。这些固定的值，又叫做字面量
		常量可以是任何的数据类型
		整数常量：后面可以跟一个U、L,前者表示无符号，L表示长整数，也可以小写，无顺序要求
			0X便是十六进制
			0表示八进制
		浮点常量：由整数部分、小数点、小数部分和直属部分。
			使用指数形式时，必须保证整数部分，小数部分，或者同时包含两者
		... 

		定义常量
			1）使用#define预处理器
				#define identifier value
				#define LENGTH 10
				#define WIDTH 5
			2）使用const关键字
				const tyoe variable = value;


	C存储类
		存储类定义C程序中变量/函数的范围(可见性)和生命周期。这些说明符放在所修饰的类型之前。
		C程序中可用的存储类
			auto 只能用在函数内
				所有[局部变量]默认的存储类。 { int mount; auto int month;}
			register 
				定义存储在寄存器而不是RAM中的局部变量。这意味着变量的最大尺寸等于寄存器的大小，通常是一个词。而不能对它应用一元运算符&,因为它没有内存位置。
				{ register int miles; }
			static
				该存储类指示编译器在程序的生命周期内保存局部变量的存在，而不需要在每次它进入和离开作用域时进行创建和销毁。因此，使用static修饰局部变量可以在函数调用之间保持局部变量的值。
				也可以以用于全局变量。当static修饰全局变量时，会使变量的作用域限制在声明他它的文件内。
				在C编程中，当static用在类数据成员上时，会导致仅有一个该成员的副本被类的所有对象共享
			extern
				用于提供一个全局变量的【引用】，对所有程序文件都是可见的。使用 extern 关键字时，对于无法初始化的变量，会把变量名指向一个之前定义过的存储位置

				当你有了多个文件且定义一个可以在其他文件中使用的全局变量或者函数时，可以在其他文件中使用extern来得到已经定义的变量或者函数的引用。可以这么理解，extern是用来在另一个文件中声明一个全局变量或函数。

	C运算符
		算术运算符 	+ - * / % ++ -- 
		关系运算符	== != >= <= < > 
		逻辑运算符	&& || !(逻辑非运算符)
		位运算符		& | ^ ~ << >> 
		赋值运算符	= += -= /= %= <<= >>= &= ^= |=
		杂项			?:（三元运算符） &(返回变量的地址) sizeof() (返回变量占用的存储空间大小) |a; 将指向一个变量

	运算符的优先级及顺序
		不确定的话 就用小括号括起来

##### C基本语法
	C判断
		if(){} [else{}]
		switch() 
	C循环
		允许一次执行一个语句或者语句组.当执行离开一个范围时，所有在该范围内创建的自动对象都会销毁
		while(){}
		for(){}
		do...while

		控制语句
			break;
			continue;
			goto;
		注意要写好判断，避免无限循环。无限循环可以通过ctrl+c结束
	C函数
		每个C程序至少有一个函数，即主函数main()。
		函数声明告诉编译器函数的名称、返回类型和参数。
		函数定义提供了函数的实际主体。
		函数声明
			return_type function_name (parameter list)
			int max(int num1,int num2) //合法
			int max(int,int) //合法
			在一个源文件中定义函数，在另一个文件中调用函数时，函数声明是必须的。这时候，应该在调用函数的文件顶部声明函数
		函数定义的一般形式
			return_type function_name (parameter list) {
				body of the function;
			}
			return_type 返回类型：函数返回值的类型
			参数：就像占位符

		函数调用
			调用函数时，程序的控制权交给函数，函数执行任务后，再把程序的控制权交还给主程序

		函数参数
			函数要使用参数，必须声明接受参数值的变量，这些变量称为形参。
			形参就像函数内部变量，在进入函数时被创建，在离开时被销毁
			传值调用和引用调用(可以改变传入参数的值)

		C作用域规则
			作用域：程序中定义的变量存在的区域，超过该区域变量就不能被访问。
			声明变量的三个地方：
				1 函数或块内部的局部变量
					int main(){
						int a,b;
						a = 10;
						b = 6;
					}
				2 在所有函数外部的全局变量
					#include <stdio.h>
					int a; //全局变量，在整个程序的生命周期内都是有效的，任何函数都可以使用
					int main(){
						//局部变量可以和全局变量相同，但是函数内的局部变量会覆盖全局变量
						int b,a; //局部变量

					}
				3 在形式参数的函数参数定义中
					函数的参数作为形式参数，被当做函数内的局部变量，他们会有限覆盖全局变量

		初始化局部和全局变量
			全局变量定义时，系统会对其进行初始化
				int		0
				char	'\0'
				float	0
				double 	0
				pointer NULL
			局部变量被定义时，系统不会对其进行初始化

		C数组
			可以存储一个固定大小的、类型相同的元素的集合。
			所有的数组都是由连续的内存位置组成，最低的地址对应第一个元素，最高的地址对应最后一个元素

			声明数组
				type arrayName [arraySize]
				double balance[10] # 类型为double，包含10个元素

			初始化数组
				// 如果不指定长度，则长度为初始化时元素的个数
				double balance[5] = {1000.0,2.4,55.5,23.6,34.66};
			访问数组
				double salary = double[4];

			重要概念
				多维数组
				传递数组给函数
				从函数返回数组
				指向数组的指针

		C指针
			每一个变量都有一个内存位置，每一个内存位置都定义了可使用&运算符访问的地址，它表示了在内存中的一个地址
			示例：输出定义的变量地址
			#include <stdio.h>
			int main() {
				int var1;
				char var2[10];

				printf("Address of var1 is: %x\n", &var1); // 592c8b54 十六进制数
				printf("Address of var2 is: %x\n", &var2); // 592c8b5e

				return 0;
			}

			指针
				指针是一个变量，其值为另一个变量的地址，即内存位置的直接地址。
			指针声明形式
				type *var_name
				type:是指针的基类型，它必须是一个有效的C数据类型
				int *ip; //一个整型的指针
				ip代表一个变量的地址。
				*ip则可以根据地址找到并返回地址中存储的数据。
			NULL指针
				为指针变量赋一个NULL是一个良好的习惯，被称为空指针。NULL被定义为一个定义在标准库中的值为0的常量。大多数系统中，程序不允许访问地址为0的内存。
			检查指针是否问空指针
			if(ptr) 
			if(!ptr)

			重要概念
				指针的算术运算 	++ -- + - 
				指针数组 			可以定义用来存储指针的数组
				指向指针的指针		C允许指向指针的指针
				传递指针给函数		通过引用或地址传递能使传递的参数在调用函数中被改变
				从函数中返回指针	C允许函数返回指针到局部变量、静态变量和动态内存分配
		C字符串
			在C语言中，字符串实际上是使用null 或 '\0'种植的一堆字符数组。因此一个以null结尾的字符串，包含了组成字符串的字符。
			char greeting[6] = {'H', 'e', 'l','l','0','\0'};
			char greeting[] = 'Hello';

		C结构体
			是一种用户自定义的可用的数据类型，它允许你存储不同的数据项。
			定义结构
				struct [structure tag]
				{
					member definition;
					number definition;
					...
					number definition;
				} [one or more structure variables]
				示例：书的结构
				struct Books 
				{
					char title[50];
					char author[50];
					char subject[100];
					int book_id;
				} book; [不能少，否则报错]
			访问结构成员
				访问运算符 .
				Book1.title

				int main() {
					struct Books Book1;
					struct Books Book2;
		
				  	//Book1详情
			        strcpy(Book1.title, "C Programing");
			        strcpy(Book1.author, "Nuha Ali");
			        strcpy(Book1.subject, "C Programing Tutorial");
			        Book1.book_id = 6495700;
			 
			        // Book2详情
			        strcpy(Book2.title, "Telecom Biling");
			        strcpy(Book2.author, "Zara Ali");
			        strcpy(Book2.subject, "Telecom Billing Turtorial");
			        Book2.book_id = 5487658;
				}
			
			指向结构的指针
				// 声明
				struct Books *struct_pointer; 
				// 初始化
				struct_pointer = &Book1;
				使用指向该结构的指针访问结构的成员
				struct_point->title;

			位域
				有些信息在存储时，不需要占用一个完整的字符，如0 1 开关
				把一个字节中的二进位划分为几个不同的区域，并说明每个区域的位数
				每个域有一个域名，允许在程序中按域名进行操作。这样就可以把几个不同的对象用一个字节的二进制为域来表示

				位域的定义
					struct 位域结构名
					{
						位域列表 --> 类型说明符 位域名:位域长度
					}
					struct bs {
						int a:8;
						int b:2;
						int c:6;
					} data;
					上面的意思是： data为bs变量，共占2个字节。位域a占8位...

				说明：
					1)一个位域必须存储在同一个字节中，不能跨两个字节。如果一个字节中剩余空间不够存放另一个位域，应该从下一个单元起存放该位域。
					struct bs{
						unsigned int a: 4;
						unsigned :4;	// 空域，无法使用，占位
						unsigned int b:4;
					}
					2)位域可以是无名位域，这时它只用来作填充或者调整位置，不能使用。
					3)位域不允许跨两个字节，因此其长度不能大于一个字节的长度。如果超过，有些编译器可能允许内存重叠，另外一些可能把剩余的部分存储在下一个字节中

				位域的使用
					位域变量名.位域名
					位域也可以使用指针
					示例看脚本 bit_struct.c

		C共用体
			共用体是一种特殊的数据类型，运行你在相同的内存位置存储不同类型的数据。
			你可以定义一个带有多成员的共同体，但是任何时候只能有一个成员带有值。

			定义：
				union [union tag] {
					member definition;
					member definition;
					...
					member definition;
				}[one or more union variables];

				union Data {
					int i;
					float f;
					char str[20];
				} data;
				Data类型变量可以存储一个整数，一个浮点数或者一个字符串。其占用内存应足够存储共用体中最大的成员

			访问共同体成员
				Data.i Data.f
				示例见union.c

		C位域
			struct {
				unsigned int widthValidated;
				unsigned int heightValidated;
			} status;
			sizeof(status) // 8

			struct {
				unsigned int widthValidated: 1;
				unsigned int heightValidated: 1;
			} status2;
			sizeof(status2) // 4,如果超过33位，将会占用8个字节

			位域声明
				struct 
				{
					type [member_name] : width;
				};
				type:整数类型，决定了如何解释位域的值，可以使整型，无符号或有符号整型
				member_name: 位域的名称
				width: 位域 位的数量。宽度必须小于或等于指定类型的位宽度

				struct 
				{
					unsigned int age:3
				} Age;

		C typedef 
			为【类型】取一个新的名字
			typedef unsigned char BYTE; //为unsigned char起一个别名BYTE
			// 示例
			typedef struct Books{
				char title[50];
			} Book;
			int main() {
				Book book;

				return 0;
			}

			typedef vs #define
			#define是C指令，用于为各种数据类型定义别名，与typedef类似。
				1）typedef仅限于为类型定义符号名称，#define不仅可以为类型定义别名，也能为数值定义别名，比如你可以定义1为 one
				2）typedef是由编译器执行解释的，#define语句是由预编译器进行处理的
			//示例
			#include <stdio.h>
			#define TRUE 1
			#define FALSE 0

			int main() {
				printf("value of TRUE: %d\n", TRUE); //1
				printf("value of FALSE: %d\n", FALSE); //0
				return 0;
			}

##### C输入与输出
	输入，表示向程序填充一些数据。输入可以是以文件的形式或从命令行中进行
	输出，意味着要在屏幕、打印机或者文件中显示一些数据

	C语言把所有设备都当做文件，设备被处理的方式与文件相同。以下三个文件会在程序执行时自动打开，以便访问键盘和屏幕
	标准文件		文件指针		设备
	标准输入		stdin		键盘
	标准输出		stdout		屏幕
	标准错误		stderr		你的屏幕

	getchar() & putchar() 函数
		int getchar(void) 可以从屏幕读取一个可用字符，并把它返回为一个整数。
		int putchar(int c) 把字符输出到屏幕上
		示例见 get_put_char.c

	gets() & puts() 函数
		char gets(char s)函数从stdin读取一行到s所指向的缓冲区，直到一个终止符或者EOF
		*int puts(const char s)函数把字符串s和一个尾随的换行符写到stdout
		示例见 gets_puts_func.c

	scanf() & printf()函数
		*int scanf(const char format,...) 函数从标准输入流stdin读取输入，并根据提供的format来浏览输入
			遇到一个空格就会中止 hello world会被当做两个输入
		*int printf(const char format,...) 函数把输出写入到标准输出流stdout，并根据提供的格式产生输出
		示例见scanf_printf_func.c

##### C文件读写
	打开文件
		fopen()
		模式 r 	w	a 	r+ 	w+ 	a+ 	
		二进制 rb wb	ab	rb+ r+b wb+ w+b ab+ a+b
	关闭文件
		fclose()  // return 0;关闭成功  EOF 关闭失败
		会清空缓冲区中数据，关闭文件，用于释放该文件的所有内存。
	写入文件
		fputc(int c, FILE *fp) //写入成功， 返回写入的字符，发生错误，返回EOF
		fputs(const char *s,FILE *fp) //写入字符串。写入成功，返回一个非负值，否则返回EOF
		fprintf(fp, str)
		示例见 write_file.c 
	读取文件
		fgetc() //返回值时读取的字符，如果发生错误则返回EOF
		fgets(*buf, int n , FILE *fp) //从fp所指向的输入流中读取n-1个字符，把读取到的字符串复制到缓冲区，并在最后追加一个null来终止字符串





