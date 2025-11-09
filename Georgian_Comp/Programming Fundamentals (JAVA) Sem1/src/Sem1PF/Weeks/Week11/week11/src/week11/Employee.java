package week11;

public class Employee {
    String name;
    int id;

    Employee(){
        name = "not assigned";
        id = 1;
    }

    Employee(String n, int i){
        name = n;
        id = i;
    }

    public void displayInfo(){
        System.out.println("Employee name: " + name + ", ID: " + id);
    }
}
