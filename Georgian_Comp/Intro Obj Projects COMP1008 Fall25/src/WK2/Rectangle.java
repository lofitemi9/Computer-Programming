package WK2;

public class Rectangle {

    private int length = 3, width = 3;

    public void setLength(int l) {
        if(l >= 3)
            length = l;
    }

    public int getLength() {
        return length;
    }

    public void setWidth(int w) {
        if(w >= 3)
            width = w;
    }

    public int getWidth() {
        return width;
    }

    public Rectangle(int length, int width) {
        setLength(length);
        setWidth(width);
    }

    public String toString() {
        return String.format("Rectangle as a length of % and a width if %d\n",
                length, width);
    }

    public boolean equals(Object o) {
        if(o instanceof Rectangle) {
            Rectangle r = (Rectangle) o;
            return length == r.length && width == r.width;
        }
        else return false;
    }

    public int area() {
        return length * width;
    }

    public int perimeter() {
        return 2 * (length + width);
    }

    public boolean haveSameArea(Rectangle r) {
        return this.area() == r.area();
    }

    public boolean haveSamePerimeter(Rectangle r) {
        return this.perimeter() == r.perimeter();
    }
}
