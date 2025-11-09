package Sem1PF.Weeks.Week10;

public class wk10 {

    static int globalVal = 100; 
    static int value = 42;

    public static void main(String[] args) {
        
        int localValue = 25; //Local Variable
        System.out.println("Global Value in main(): " + globalVal);
        System.out.println("Local Value in main(): " + localValue);
        System.out.println();
        demonstrateScope();

        int value = 24; //Local variable that shadows the global variable
        System.out.println();
        System.out.println("Value in main(): " + value); //referring to local variables
        display();

        int number = 6;
        System.out.println("Factorial of " + number + " is: " + factorial(number));

        int n = 6;
        System.out.println("Fibonacci number at position: " + n + " is: " + fibonacci(n));
        
    }


    public static int fibonacci(int n){
        if (n==0) return 0;
        if (n==1) return 1;
        return fibonacci(n-1) + fibonacci(n-2);
        // fibonacci of 10 --> 1+2=3, 3+2=5, 3+5=8, 5+8=13..
    }

    public static int factorial(int n){
        if (n==0 || n==1 ){
            return 1;
        }
        return n*factorial(n-1);
    }


    public static void demonstrateScope(){
        int localValue = 50; //Local to this method only
        System.out.println("Global Value in main(): " + globalVal);
        System.out.println("Local Value in demonstrateScope(): " + localValue);
    }

    public static void display(){
        System.out.println("Value in display(): " + value);
    }

}
