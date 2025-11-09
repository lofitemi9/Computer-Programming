package Sem1PF.Weeks.Week9;

public class week9practice {
    
    public static void main(String[] args) {
        // Number 1
        int h = 5;
        int l = 5;

        int area = calculateArea(h, l);
        System.out.println("The area is: "  + area);

        // Number 2
        int number = 3;
        if (isEven(number)){ 
            System.out.println(number + " is Even");
        }
        else{
            System.out.println(number + " is Odd");
        }

        // Number 3
       int tableNumber = 7;
       System.out.println("Multiplication table for " + tableNumber + ":");
       printMultiplicationTable(tableNumber);
        
        // Number4
        int hours = 5;
        int minutes = 32;

        int converted = convertToSeconds(hours, minutes);
        System.out.println("Converted to Seconds: " + converted);

        // Number5
        int a = 5;
        int b = 10;
        swapValues(a, b);

        // Number6
        int x = 5;
        int y = 10;
        double j = 5.34;
        double f = 6.20;
        int addint = add(x, y);
        double addouble = add(j, f);

        System.out.println("Added int: " + addint + " \n " + "Added double: " + addouble);

        // Number14
        String[] words = {"Hello", "How", "Yeah"};
        capitalizeWords(words);
        printWords(words);

        // Number8
        int a1 = 5;
        int a2 = 8;
        int a3 = 5;
        double r = 62.5;

        int volumeCube = calculateVolume(a1);
        System.out.println("The volume of a Cube is: " + volumeCube);

        int volumeCuboid = calculateVolume(a1, a2, a3);
        System.out.println("The volume of a cuboid is: " + volumeCuboid);

        double volumeSphere = calculateVolume(r);
        System.out.println("The volume of a sphere is: " + volumeSphere);

        // Number7
        String name = "Temi";
        greet(name);
        
        greet();

        // Number8
        int num1 = 10;
        int num2 = 20;
        int num3 = 30;

        int maxnum = max(num1, num2);
        int maxnum2 = max(num1, num2, num3);

        System.out.println("The maximum number of the 2 is: " + maxnum);
        System.out.println("The maximum number of the 3 is: " + maxnum2);

        // Number9
        int age = 18;
        String id = "Tems";

        printDetails(id);
        printDetails(id, age);

        // Number11
        int stars = 15;
        printStars(stars);

        // Number12
        String message = "\n Hey how are you \n";
        displayMessage(message);

        // Number15
        int rows = 5;
        drawTriangle(rows);
    }

    // Number1
    public static int calculateArea(int length, int width){
        return length * width;
    }
    // Number2
    public static boolean isEven(int number){
        return (number % 2 == 0);
    }
    // Number3
    public static void printMultiplicationTable(int n){
        for(int i = 1; i <= 10; i++){
            System.out.println(n + "x" + i + "=" + (n * i));
        }
    }
    // Number4
    public static int convertToSeconds(int hours, int minutes){
        int hourstoseconds = hours * 3600;
        int minutestoseconds = minutes * 60;
        return hourstoseconds + minutestoseconds;
    }
    // Number5
    public static void swapValues(int a, int b){
        int temp = a;
        a = b;
        b = temp;
        System.out.println("A is now: " + a + " B is now: " + b);
    }
    // Number6
    public static int add(int a, int b){
        return a + b;
    }
    public static double add(double a, double b){
        return a + b;
    }
    // Number14
    public static void capitalizeWords(String[] words){
        for(int i=0; i<words.length; i++){
            if (!words[i].isEmpty()) {
                words[i] = words[i].toUpperCase();
            }
        }
    }
    public static void printWords(String[] words) {
        for (String w : words) {
            System.out.print(w + " ");
        }
        System.out.println();
    }
    // Number8
    public static int calculateVolume(int side){
        return side * side * side;
    }
    public static int calculateVolume(int length, int width, int height){
        return length * width * height;
    }
    public static double calculateVolume(double radius){
        return(4.0/3.0) * Math.PI * Math.pow(radius, 3);
    }
    // Number7
    public static void greet(String name){
        System.out.println("Hello, " + name);
    }
    public static void greet(){
        System.out.println("Hello Everyone");
    }
    // Number10 
    public static int max(int a , int b){
        return Math.max(a, b);
    }
    public static int max(int a , int b , int c){
        return Math.max(a, Math.max(b, c));
    }
    // Number9
    public static void printDetails(String name){
        System.out.println("The  users name is: " + name);
    }
    public static void printDetails(String name, int age){
        System.out.println("The users name is: " + name + "\n The users age is: " + age);
    }
    // Number11
    public static void printStars(int n){
        for(int i=0; i<n; i++){
            System.out.print("*");
        }
    }
    // Number12
    public static void displayMessage(String message){
        for(int i=0; i<5; i++){
            System.out.print(message); 
        }
        
    }
    // Number15
    public static void drawTriangle(int rows) {
        for (int i = 1; i <= rows; i++) {
            for (int j = 1; j <= i; j++) {
                System.out.print("*");
            }
            System.out.println(); // Move to next line after each row
        }
    }



}

