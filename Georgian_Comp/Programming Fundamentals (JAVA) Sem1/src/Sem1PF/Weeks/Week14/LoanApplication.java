package Sem1PF.Weeks.Week14;

import javax.swing.plaf.TreeUI;

public class LoanApplication {

    String name;
    double amount;
    int credit_score;

    LoanApplication(String name, double amount, int credit_score){

        this.name = name;
        this.amount = amount;
        this.credit_score = credit_score;
    }

    boolean isApproved(){
        return credit_score >= 650 && amount < 20000;
    }
}
