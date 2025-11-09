package Sem1PF.Weeks.Week3;
import java.util.Scanner;


public class WK3 {
    
    public static void main(String[] args) {
        
        Scanner Scanner = new Scanner(System.in);
        String input;
        int dayNumber = 3;
        switch (dayNumber){
            case 1:
                System.out.println("Monday");
                break;
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

        }
        
        //loops
        	//for loop
        	for (int i = 1; i <=10; i++) {
        		System.out.println("Number: " + i);
        	}
        	
        	System.out.println();
        	for (int i = 1; i <= 5; i++) {
        		for (int j = 1; j<=5; j++) {
        			System.out.println(i + "*" + j +  "=" + (i*j));
        		}
                System.out.println();
        	}

            //while loop
            int start = 1;
            int end = 10;
            int sum = 0;
            while(start <= end){
                sum += start;
                start++;
            }
            System.out.println("The sum of the first 10 numbers is: " + sum);

            //do while
            do{
                System.out.println("Enter something (exit to leave): ");
                input = Scanner.nextLine();
                System.out.println(input);
            }while(!input.equalsIgnoreCase("exit"));
            System.out.println("Exiting the program..");
            Scanner.close();



            //break and continue
            int[] numbers = {3,5,7,8,9,10};
            for(int num : numbers){
                if (num % 2 != 0){
                    continue;
                }
                System.out.println("the first even number is " + num);
                break;
            }

            System.out.println();
            //labelled loops
            outerLoop:
                for(int i = 1; i <=3; i++){
                    for(int j = 1; j<=3; j++){
                        System.out.println("i ="+ i+ ", j = " + j);
                        if(i == 2 && j == 2){
                            System.out.println("Breaking out of both loops.");
                            break outerLoop;
                        }
                    }
                }

        
    }

}
