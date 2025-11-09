package Sem1PF.Weeks.Week9;

public class week9 {

    // global variable
    static int globalVariable = 10;
    public static void main(String[] args) {
       
        // local variables - defined inside the main
        int length = 5;
        int width = 3;


        // Call a method inside the main method
        int arearectangle = calculateArea(length, width);
        int areasquare = calculateArea(4, 4);

        System.out.println("The area of the rectangle is: " +  arearectangle);
        System.out.println("The area of the square is: " +  areasquare);
        
        greeting();
        greeting("Temi");

        double r = 7.89;
        double areaCircle = calculateArea(r);
        System.out.println("The area of the circle is: " + areaCircle);

        // accessing global and local variables
        System.out.println("Global variable: " + globalVariable);
        System.out.println("Local Variable: " + length);
    }

    // defining a method outside the main method
    public static int calculateArea(int length, int width){
        return length * width;
    }

    public static double calculateArea(double radius){
        return Math.PI * radius * radius;
    }

    public static void greeting(){
        System.out.println("Welcome to Java");
    }
        
    // method overloading
    public static void greeting(String name){
        System.out.println(name + ", Welcome to Java");
    }



    
}
