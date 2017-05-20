#include <iostream>
#include <cmath>
#include <cassert>
#include <fstream>
#include <cstdlib>
#include <conio.h>
using namespace std;

class ArrayList{
public:
    static const int MAX_SIZE = 100; // So phan tu toi da cua mang
    ArrayList(); // Khoi tao danh sach rong
    ArrayList(int a[], int n); // Khoi tao DS bang du lieu luu trong mang a
    ArrayList(const char * filename); // Khoi tao DS bang du lieu luu trong tep filename

    bool empty() const; // Kiem tra DS rong hay khong
    int length() const; // Xac dinh do dai DS
    void insert(const int x, int i); // Xen gia tri x vao vi tri i trong DS
    void append(const int x); // Them x vao duoi DS
    void erase(int i); // Loai khoi DS phan tu o vi tri i
    int& at(int i); // Tra ve tham chieu toi phan tu o vi tri i
    void print() const; // In ra man hinh toan bo DS
private:
    int element[MAX_SIZE]; // Mang tinh element luu toan bo DS
    int last; // chi so cua phan tu cuoi cung
};

ArrayList::ArrayList()
{
    last = -1;
}

ArrayList::ArrayList(int a[], int n)
{
    last = n - 1;
    for(int i = 0; i <= last; i++)
    	element[i] = a[i];
}

ArrayList :: ArrayList(const char *filename)
{
    fstream file;
    int i, N;
	cout << last << endl;
	file.open(filename, ios::in);
	if(file.fail())
	{
		cout << "Can not open input.txt file." << endl;
		exit(1);
	}

	i = 0;
	while(!file.eof())
	{
		file >> N;
		element[i] = N;
		i++;
		if(i > MAX_SIZE) break;
	}
	last = i - 1;
	file.close();
}

bool ArrayList::empty() const
{
    if(last < 0) return false;
	else   return true;
}

int ArrayList::length() const
{
    if(last < 0) return 0;
    else return last + 1;
}

void ArrayList::insert(const int x, int i)
{
    assert(last < MAX_SIZE - 1 && i <= last);
    for(int j = last + 1; j > i; j--)
    	element[j] = element[j-1];

    element[i] = x;
    last = last + 1;
}

void ArrayList::append(const int x)
{
    assert(last < MAX_SIZE - 1);
    element[last + 1] = x;
    last = last + 1;
}

void ArrayList::erase(int i){
    assert(last >= 0 && i <= last && i >= 0);

    for(int j = i; j <= last; j++)
    	element[j] = element[j + 1];
    last = last - 1;
}

int& ArrayList::at(int i){
    assert(last >= 0 && i <= last && i >= 0);
    return element[i];
}

void ArrayList::print() const
{
	if(last < 0);
	else{
		for(int i = 0; i <= last; i++)
			cout << element[i] << " ";
	}
}

int main()
{
    cout << "Chuong trinh test KDLTT danh sach so nguyen" << endl;
    cout << "Tac gia: Pham Van Linh\n--------------------" << endl;

    cout << "L1: L1.append(3);L1.append(4);L1.append(5);"
        << "L1.insert(2, 0); L1.insert(1, 0); L1.insert(3, 2);" << endl;

	int a[] = {1, 9, -3, 23, -5, 4, 8};
	int n = 7;
    ArrayList L1(a, n);
	L1.print(); cout << endl;
    L1.append(3); L1.print(); cout << endl;
    L1.append(4); L1.print(); cout << endl;
    L1.append(5); L1.print(); cout << endl;
    L1.insert(2, 0); L1.print(); cout << endl;
    L1.insert(1, 0); L1.print(); cout << endl;
    L1.insert(3, 2); L1.print(); cout << endl;

    cout << "\nL2: L2.append(4);L2.append(4);L2.append(1);"
        << "L2.erase(2); L2.insert(5, 1); L2.insert(3, 2);" << endl;

    ArrayList L2(a, n);
    L2.append(4);
    L2.append(4);
    L2.append(1);
    L2.erase(2);
    L2.insert(5, 1);
    L2.insert(3, 2);
    cout << "L2.at(3): " << L2.at(3) << endl;
    L2.print();
    cout << endl;

    cout << "\nL3: input.txt" << endl;
    ArrayList L3("input.txt");
   	L3.print();
    getch();

    return 0;
}
