package WK1;

import java.util.Scanner;

public class Form {

    private String firstname, lastname;
    private int age;
    private double height, weight;

    public void getFirstname() {
        Scanner input = new Scanner(System.in);
        firstname = input.nextLine();
    }

    public void setFirstname() {
        this.firstname = firstname;
    }

    public void getLastname(String lastname) {
        Scanner input = new Scanner(System.in);
        lastname = input.nextLine();
    }

    public void setLastname(String lastname) {
        this.lastname = lastname;
    }

    public int getAge(int age) {
        Scanner input = new Scanner(System.in);
        age = input.nextInt();
        return age;
    }

    public void setAge(int age) {
        this.age = age;
    }

    public double getHeight(double height) {
        Scanner input = new Scanner(System.in);
        height = input.nextDouble();
        return height;
    }

    public void setHeight(double height) {
        this.height = height;
    }

    public double getWeight(double weight) {
        Scanner input = new Scanner(System.in);
        weight = input.nextDouble();
        return weight;
    }

    public void setWeight(double weight) {
        this.weight = weight;
    }
}
