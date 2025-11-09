//package WK2;
//
///**
// * Working with a Form Class
// * @author Temi
// *
// */
//
//public class Form {
////    first, last, height, weight, age
//
//    private String name;
//    private int age;
//    private double height;
//    private float weight;
//
////    right-click => Generate
//
//
//    public Form(String name, int age, double height, float weight) {
//        setName(name);
//        setAge(age);
//        setHeight(height);
//        setWeight(weight);
//    }
//
//
//    public String getName() {
//        return name;
//    }
//
//    public void setName(String name) {
//        if(name.length()<2){
//        this.name = name;
//        }
//    }
//
//    public int getAge() {
//        return age;
//    }
//
//    public void setAge(int age) {
//        if(age>=0 && age<=100) {
//            this.age = age;
//        }
//    }
//
//    public double getHeight() {
//        return height;
//    }
//
//    public void setHeight(double height) {
//        if (height >= 50 && height <= 300) {
//            this.height = height;
//        }
//    }
//
//    public float getWeight() {
//        return weight;
//    }
//
//    public void setWeight(float weight) {
//        if(weight >0)
//            this.weight = weight;
//        }
//
//    public String toString(){
//      s = string, d = digit(whole number), f = float/double(decimal number)
//        return String.format("Name = %s, Age = %d, Height = %.1f, Weight = %.2f",
//                name,age,height,weight);
//    }
//
//
//    }
//
//
//
