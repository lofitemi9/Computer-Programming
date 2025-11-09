package week11.Practice.questions;

public class practice {

    public static void main(String[] args) {
        q1 bc = new q1();
        bc.bal = 100.0;
        bc.bank_check();

        int depos = bc.deposit(0, 1000);

        System.out.println("deposit is: " + depos);

    
}
    }

