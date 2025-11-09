package WK2;

public class square {

    int length;
    int width;

    public square(int length, int width) {
        this.length = length;
        this.width = width;
    }

    public int getLength() {
        return length;
    }

    public void setLength(int length) {
        if (length >= 2) {
            this.length = length;
        }
    }

    public int getWidth() {
        return width;
    }

    public void setWidth(int width) {
        if (width >= 3) {
            this.width = width;
        }
    }

    public String toString() {
//      s = string, d = digit(whole number), f = float/double(decimal number)
        return String.format("length = %d, width = %d",
                length, width);
    }

    public boolean isEqual() {
        if(length == width) {
            return true;
        }
        return false;
    }
}


