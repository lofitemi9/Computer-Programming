package week11.Practice.questions;

public class q1 {

String name;
int acc_num;
double bal;

public void bank_check(){
    System.out.println("Your account balance is: " + bal);
}

public void bank_name(){
    System.out.println("Your Name is: " + name);
}

public void bank_num(){
    System.out.println("Bank number is: " + acc_num);
}

public static int deposit(int bal, int depo){
    return bal + depo;
}


}
