import java.util.Scanner;

public class LAB3 {

    public static void main(String[] args) {
        // Develop a program that converts a string to lowercase using toLowerCase() and prints the result.

        Scanner scanner = new Scanner(System.in);

        System.out.println("Gimme a word FN: ");
        String word = scanner.nextLine();

        scanner.close();


        System.out.println("Lowercase: " + word.toLowerCase());
    }

}
