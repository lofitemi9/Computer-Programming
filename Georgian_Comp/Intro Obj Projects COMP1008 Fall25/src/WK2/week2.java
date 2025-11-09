//package WK2;
//
//import javax.xml.namespace.QName;
//import java.io.Console;
//
//public class week2 {
//
//    public static void main(String[] args) {
//
//        System.out.println("Hello you will be asked about a series of questions");
//        System.out.println("Then you will be sent a product free of charge");
//
//        Console console = System.console();
//
//        System.out.print("Enter your name: ");
//        String name = console.readLine();
//
//        System.out.println("Enter your age: ");
//        int age = Integer.parseInt(console.readLine());
//
//        System.out.println("Enter your height: ");
//        double height = Double.parseDouble(console.readLine());
//
//        System.out.println("Enter your weight: ");
//        float weight = Float.parseFloat(console.readLine());
//
//        Form form = new Form(name, age, height, weight);
//        System.out.println(form.getName());
//        form.setAge(age);
//        System.out.println(form.getName());
//
//        System.out.println(form); //method named toString() is implicitly related
//        System.out.println(form.hashCode());
//    }
//
//    static void example2(){
//
//        Form f1 = new Form(name: "Ben", age: 30, height: 150, weight: 160);
//        Form f2 = new Form(name:"Ben", age: 30, height: 150, weight: 160);
//        Form f3 = new Form(name:"Ben", age: 30, height: 150, weight: 160);
//
//        Form f4 = f1;
//
//        System.out.println(f1.equals(f2));
//        System.out.println(f1.equals(f4));
//    }
//
//    static void example1(){}
//
//}
