package exam;

// Write a complete Java program that uses a common interface to represent different media types that can be played in the same way.

// Define an interface Playable with method void play().
// Implement class Song that implements Playable and:
// Has a field String title and a constructor to set it.
// Implements play() to print a message like "Playing song: " followed by the title.
// Implement class Video that implements Playable and:
// Has a field String title and a constructor to set it.
// Implements play() to print a message like "Playing video: " followed by the title.
// In public class Main:
// Import java.util.ArrayList and java.util.List.
// Create a List<Playable> named, for example, playlist and add several Song and Video objects to it.
// Use a for-each loop to iterate over the list and call play() on each Playable element.
// All objects must be stored and used through the Playable interface type to demonstrate polymorphism.



public interface Playable {
    void play();
}

class Song implements Playable {
    private String title;

    public Song(String title) {
        this.title = title;
    }

    @Override
    public void play() {
        System.out.println("Playing song: " + title);
    }
}
class Video implements Playable {
    private String title;

    public Video(String title) {
        this.title = title;
    }

    @Override
    public void play() {
        System.out.println("Playing video: " + title);
    }
}





