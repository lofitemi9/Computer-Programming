package WK2;

public class runRectangle {

    public static void main(String[] args) {
        Rectangle r1 = new Rectangle(8, 5);
        Rectangle r2 = new Rectangle(4, 10);

        System.out.println(r1.haveSameArea(r2));
        System.out.println(r1.haveSamePerimeter(r2));


    }
}
