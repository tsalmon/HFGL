#include <stdio.h>
#include <stdlib.h>

int main(int argc, char **argv)
{
	int a = atoi(argv[1]);
	int b = atoi(argv[2]);
	int res = a+b;
	printf("%i + %i = %i\n", a, b, res); 
	return res;
}
