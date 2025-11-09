package week11;

public class Student {
    String name;
    int age;

    // constructor
    Student(){
        name = "Default Name";
        age = 18;

    }

    public void display(){
        System.out.println("Student name: " + name);
        System.out.println("Age " + age);
    }
}
