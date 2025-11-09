import java.util.Scanner;

public class wekk8practice {
    public static void main(String[] args) {
        
        // Number 1
        String greeting = "Hello";
        System.out.println(greeting);
        String greeting2 = new String("Hello");
        System.out.println(greeting2);

        // Number 2
        System.out.println("First and Last Char: " + greeting.charAt(0) +"  "+greeting.charAt(greeting.length()-1));

        // Number 3
        System.out.println("Concatenated String: " + greeting + greeting2);

        // Number 4
        System.out.println("Concat Method: " + greeting.concat(greeting2));

        // Number 5
        System.out.println("Length of String: " + greeting.length());

        // Number 6
        System.out.println("Equals?: " + (greeting == greeting2));
        System.out.println("Equals?: " + greeting.equals(greeting2));
        
        // Number 7
        System.out.println("Are they Equal ignoring case: " + greeting.equalsIgnoreCase(greeting2));

        // Number 8
        String str1 = "Hola";
        Scanner input = new Scanner(System.in);
        
        System.out.println("Pick A Word: ");
        String str2 = input.nextLine();

        if (str1.equalsIgnoreCase(str2)) {
            System.out.println("Are they Equal: " + str1.equalsIgnoreCase(str2));
        }
        else{
            System.out.println("They are not equal");
        }

        // Number 9 


        // Number 10
        System.out.println("Using compareTO: " + str1.compareTo(str2));

        // Number 11
        System.out.println("Substring: " + str1.substring(0,4));

        // Number 14
        System.out.println("First three letters to Upper: " + str1.substring(0,3).toUpperCase());

        // Number 15
        System.out.println("Last Word: " + str2.substring(str2.length()-1));

        // Number 16 
        StringBuilder sb = new StringBuilder("Hola");
        sb.append(", Encatado de Conocerte");
        System.out.println("StringBuilder: " + sb.toString());

        //Number 17
        sb.insert(5, "Hi");
        System.out.println("Inserted: " + sb.toString());

        // Number 18
        sb.reverse();
        System.out.println("Reversed: " + sb.toString());

        // Number 19
        sb.reverse();
        sb.delete(5, 7);
        System.out.println("Deleted: " + sb.toString());

        // Number 20
        sb.replace(0, 4, "Hello");
        System.out.println("Replaced: " + sb.toString());

        // Number 21
        for(int i=0; i<str2.length()/2; i++){
            if (str2.charAt(i) != str2.charAt(str2.length()-i-1)) {
                System.out.println("This is not a Palindrome");
                break;
            }
            else{
                System.out.println("This is a Palindrome");
                break;
            }
        }

    }

}
