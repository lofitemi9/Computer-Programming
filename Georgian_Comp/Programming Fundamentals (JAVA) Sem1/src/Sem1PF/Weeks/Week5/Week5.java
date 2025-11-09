package Sem1PF.Weeks.Week5;

public class Week5 {
    
    public static void main(String[] args) {

        int[] numbers = {10, 20, 30, 40 ,50};
        System.out.println("Printing the elements of array numbers:");
        for(int i = 0; i<numbers.length; i++){
            System.out.println("Numbers at index " + i + " is " + numbers[i]);
        }

        System.out.println();
        System.out.println(numbers[3]);
        numbers[3] = 44;
        System.out.println(numbers[3]);

        System.out.println("Printing the elements of array numbers:");
        for(int i = 0; i<numbers.length; i++){
            System.out.println("Numbers at index " + i + " is " + numbers[i]);
        }

        int[] grades = {35, 67, 89, 60, 100, 88, 26, 35};
        int min = grades[0];
        int max = grades[0];

        for(int gr : grades){
            if(gr < min){
                min = gr;
            }
            if(gr > max){
                max = gr;
            }
        }

        System.out.println("Minimum is "+ min);
        System.out.println("Maximum is "+ max);


        System.out.println();
        int[] grades2 = {35, 67, 89, 60, 100, 88, 26, 35};
        for(int i = 0; i<grades2.length; i++){
            for(int j = 0; j<grades2.length-1-i; j++){
                if(grades2[j]>grades2[i]){
                    int temp = grades2[i];
                    grades2[i] = grades2[i + 1];
                    grades2[i + 1] = temp;
                }
            }
        }

        for(int grs : grades2){
            System.out.println(grs + ", ");
        }

        System.out.println();
        int[] grades3 = {35, 67, 89, 60, 100, 88, 26, 35};
        int target = 88;
        boolean flag = false;
        for (int i = 0; i < grades3.length; i++){
            if(grades3[i] == target){
                System.out.println("Target found at index " + i);
                flag = true;
                break;
            }

            if(!flag){
                System.out.println("Target not found in the array");
            }

        }

        



        



    }

}
