public class Practice {

    public static void main(String[] args) {
        //Write a program to calculate the area of a rectangle using two int variables for length and width.

        int length = 10;
        
        int width = 10;

        System.out.println("The area of a rectangle is: " + length*width);

    

        //Create a program that declares a boolean variable isJavaFun and assigns it true. Print a message
        //based on its value (e.g., "Java is fun!" if true). Write a simple program that prints "My name is
        //[Your Name]" and verify that it runs successfully.


        boolean isJavaFun = true;

        if (isJavaFun)  {
            System.out.println("Java is Fun");
        }

        else{
         System.out.println("Java is not Fun");
        }




        int number = 12;


        // Check if the number is even
        if (number % 2 == 0) { // Modulus operator (%) checks remainder
        System.out.println("The number is even.");
        // Nested if to check if the number is greater than 10
        
            if (number > 10) {
            System.out.println("The number is also greater than 10.");

            }
            else {
            System.out.println("The number is not greater than 10.");
            }
            
        } 

        else {
        System.out.println("The number is odd.");
        }

        int dayNumber = 7; // You can change this value to test different cases
        // Switch-case to determine the day of the week
        switch (dayNumber) {
        case 1:
        System.out.println("Monday");
        break; // Break exits the switch block after matching a case
        case 2:
        System.out.println("Tuesday");
        break;
        case 3:
        System.out.println("Wednesday");
        break;
        case 4:
        System.out.println("Thursday");
        break;
        case 5:
        System.out.println("Friday");
        break;
        case 6:
        System.out.println("Saturday");
        break;
        case 7:
        System.out.println("Sunday");
        break;
        default:
        System.out.println("Invalid day number!"); // Default case for invalid input


}

    int default1 = 3;
    switch (default1){
        case 1:
        System.out.println("Hello");
        break;

        case 2:
        System.out.println("Bye");
        break;

        default:
        System.out.println("Nothing");
        
    }

    int test1 = 10;
    int test2 = 50;
    System.out.println(test1);

    int answer = (test1 > test2) ? test1 : test2;
    System.out.println(answer);

    }

}
