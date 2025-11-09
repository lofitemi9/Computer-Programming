package Sem1PF.Weeks.Week14;

public class main {

    public static void main(String[] args) {
        LoanApplication la = new LoanApplication("Temi", 15000, 700);
        System.out.println("Loan approved? " + la.isApproved());
    }

}
