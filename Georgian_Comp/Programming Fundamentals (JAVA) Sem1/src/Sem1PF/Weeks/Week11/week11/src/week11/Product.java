package week11;

public class Product {
    String name;
    double price; 
    
    Product(String n, double p){
        name = n;
        price = p;
    }

    public void showProduct(){
        System.out.println("Product: " + name + ", Price: " + price);
    }
}
