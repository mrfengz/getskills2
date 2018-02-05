#include <stdio.h>
#include <string.h>

struct Books
{
	char title[50];
	char author[50];
	char subject[100];
	int book_id;
};

void printBook( struct Books *book);

int main()
{
	struct Books Book1;
	struct Books Book2;

	strcpy(Book1.title,"PHP");
	strcpy(Book1.author, "鸟哥");
	strcpy(Book1.subject, "web开发 后台技术");
	Book1.book_id = 5489795;

	strcpy(Book2.title, "Javascript");
	strcpy(Book2.author, "Jkerie");
	strcpy(Book2.subject, "Script Language");
	Book2.book_id = 87878564;
	
	printBook(&Book1);
	printBook(&Book2);
	return 0;
}

void printBook(struct Books *book) 
{
	printf("Book Title: %s\n", book->title);
	printf("Book Author: %s\n", book->author);
	printf("Book Subject: %s\n", book->subject);
	printf("Book id : %d\n", book->book_id);
}


