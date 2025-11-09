package Sem1PF.Weeks.Week4;

public class Week4 {

    public static void main(String[] args) {
        
            for(int j = 1; j <=10; j++ ){

                for(int i = 1; i <=10; i++){
                    System.out.println(j + "*" + i + "="  + (j*i));
                }
                System.out.println();
        }

            System.out.println();
            int rows = 5;
            // Outer loop for the number of rows
            for (int i = 1; i <= rows; i++) {
            // Inner loop for printing stars in each row
            for (int j = 1; j <= i; j++) {
            System.out.print("* ");
            }
            // Move to the next line after each row
            System.out.println();
        }

            System.out.println();
            int size = 8; // Size of the board
            // Outer loop for rows
            for (int row = 0; row < size; row++) {
            // Inner loop for columns
                for (int col = 0; col < size; col++) {
                // Use modulus to alternate X and O
                    if ((row + col) % 2 == 0) {
                    System.out.print("X ");
                    } else {
                    System.out.print("O ");
                    }
            }
            // Move to the next line after each row
            System.out.println();
                    }


            int rows2 = 5;
            int cols2 = 5;
            int num = 1;
            int sum = 0;
            int row2 = 1;
            // Outer loop using while
            while (row2 <= rows2) {
                // Inner loop using for
                for (int col2 = 1; col2 <= cols2; col2++) {
                    System.out.print(num + "\t");
                    // Use if to check even number
                    if (num % 2 == 0) 
                        sum += num;
                        }
                num++;
                }
                System.out.println();
                row2++;
            }

        
        


    }



