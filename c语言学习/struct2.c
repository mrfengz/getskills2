#include <stdio.h>
#include <string.h>

struct Books
{
	char title[50];
	char author[50];
	char subject[100];
	int book_id;
};

// 函数声明
void printBook(struct Books book);

int main()
{
	struct Books Book1;
	struct Books Book2;

	// Book1 详情
	strcpy(Book1.title, "C Programming");
	strcpy(Book1.author, "Nuha Ali");
	strcpy(Book1.subject, "C programming tutorial");
	Book1.book_id = 6497550;

	// Book2 详情
	strcpy(Book2.title, "Telecom Billing");
	strcpy(Book2.author, "Zara Ali");
	strcpy(Book2.subject, "Telecom Billing tutorial");
	Book2.book_id = 5647872;
	
	//输出Book1信息
	printBook( Book1 );
	//输出Book2 信息
	printBook( Book2 );
	return 0;
}

void printBook(struct Books book) 
{
	printf("Book title: %s\n", book.title);
	printf("Book author: %s\n", book.author);
	printf("Book subject: %s\n", book.subject);
	printf("Book id: %d\n", book.book_id);
}
