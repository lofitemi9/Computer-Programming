package week11;

public class week11 {

    public static void main(String[] args) {
        // Book class

        Book myBook = new Book();
        myBook.title = "Java Basics";
        myBook.author = "Jane Doe";
        myBook.displayDetails();

        System.out.println();
        // Student Class
        Student s1 = new Student();
        s1.display(); 

        System.out.println();
        Product p1 = new Product("Laptop", 999.99);
        p1.showProduct();

        System.out.println();
        Employee e1 = new Employee();
        e1.displayInfo(); 
        Employee e2 = new Employee("Alice", 102);
        e2.displayInfo();

        System.out.println();
        Car car1 = new Car();
        car1.model = "Toyota Corolla";
        car1.year = 2020;

        Car car2 = new Car();
        car2.model = "Honda Civic"; 
        car2.year = 2022;

        car1.showDetails();
        car2.showDetails();

    }

}
