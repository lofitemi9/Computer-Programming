package WK2;

import java.io.Console;

public class runsquare {

    public static void main(String[] args) {

        Console s =  System.console();

        System.out.println("Input length: ");
        int length = Integer.parseInt(s.readLine());

        System.out.println("Input width: ");
        int width = Integer.parseInt(s.readLine());
    }

}
