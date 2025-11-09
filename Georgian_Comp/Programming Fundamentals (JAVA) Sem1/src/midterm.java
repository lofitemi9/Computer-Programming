
public class midterm {

    public static void main(String[] args) {
        
        // Speed Monitor: Simulate a speed sensor recording speeds of 15 vehicles in an array. Print out any
        // speeds that exceed the limit (e.g., 100 km/h) and count how many were over the limit.

        int count = 0;

        int[] speed = {10, 20, 30, 40, 50, 60, 70, 80 ,90 ,100 ,110, 120, 130, 140, 150};

        for(int i = 0; i<speed.length; i++){
            if (speed[i]>100){
                count +=1 ;
                System.out.println("The Values exceeding 100km/h are " + i);
            }
            System.out.println("");
        }
        System.out.println("The count is " + count);
        }

    }



