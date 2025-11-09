package Sem1PF.Weeks.finals;

public class TaxiRide {


//49. Implement a 'TaxiRide' class with distance, rate per km, and passenger name. Add method to
// calculate fare and print receipt


    double distance;
    double rpkm;
    String name;

    TaxiRide(double distance, double rpkm, String name){
        this.distance = distance;   
        this.rpkm = rpkm;
        this.name = name;
    }
 
    public static double CalcFare(double distance, double rpkm){
        return n = distance * rpkm;
    }

    public static String receipt(){
        System.out.println(n)
    }

}
