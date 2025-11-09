package Sem1PF.Weeks.Week14;

public class finals {

    public static void main(String[] args) {fitnessTracker(5000, 3.2);
        ft.showSummary();

        LoanApplication la = new LoanApplication("Temi", 15000, 700);
        System.out.println("Loan approved? " + la.isApproved());

        Timer t = new Timer(3);
        t.start();
    }
}

// 31. FitnessTracker
public class FitnessTracker {
    int steps;
    double distanceKm;

    FitnessTracker(int steps, double distanceKm) {
        this.steps = steps;
        this.distanceKm = distanceKm;
    }

    double caloriesBurned() { // very simple estimate
        return steps * 0.04; // ~0.04 kcal per step
    }

    void showSummary() {
        System.out.println("Steps: " + steps + ", Distance: " + distanceKm + " km, Calories: " + caloriesBurned());
    }
}

// 32. LoanApplication
class LoanApplication {
    String name;
    double amount;
    int creditScore;

    LoanApplication(String name, double amount, int creditScore) {
        this.name = name; this.amount = amount; this.creditScore = creditScore;
    }

    boolean isApproved() {
        return creditScore >= 650 && amount <= 20000; // simple rule
    }
}

// 33. WaterBottle
class WaterBottle {
    int currentMl;
    int maxMl;

    WaterBottle(int maxMl) { this(0, maxMl); }
    WaterBottle(int currentMl, int maxMl) {
        this.maxMl = maxMl;
        this.currentMl = Math.min(currentMl, maxMl);
    }

    void refill() { currentMl = maxMl; }
    void drink(int ml) { currentMl = Math.max(0, currentMl - ml); }
}

// 34. VotingSystem
class VotingSystem {
    String voterName;
    String voterId;
    String choice;

    VotingSystem(String voterName, String voterId, String choice) {
        this.voterName = voterName; this.voterId = voterId; this.choice = choice;
    }

    boolean validId() { // super simple check
        return voterId != null && voterId.length() == 7; // e.g., ABC1234
    }
}

// 35. Computer
class Computer {
    String brand;
    int ramGb;
    String cpu;

    Computer(String brand, int ramGb, String cpu) {
        this.brand = brand; this.ramGb = ramGb; this.cpu = cpu;
    }

    void upgradeRam(int addGb) { if (addGb > 0) ramGb += addGb; }
    void showInfo() { System.out.println(brand + ", " + cpu + ", " + ramGb + "GB RAM"); }
}

// 36. DeliveryPackage
class DeliveryPackage {
    double weightKg;
    String destination;

    DeliveryPackage(double weightKg, String destination) {
        this.weightKg = weightKg; this.destination = destination;
    }

    double shippingCost() {
        if (weightKg <= 1) return 8;
        if (weightKg <= 5) return 15;
        return 25;
    }
}

// 37. ParkingMeter
class ParkingMeter {
    int minutesLeft;
    double costPerHour;

    ParkingMeter(double costPerHour) { this.costPerHour = costPerHour; }

    void addTime(double dollars) {
        int add = (int)((dollars / costPerHour) * 60);
        minutesLeft += add;
    }
}

// 38. GroceryItem
class GroceryItem {
    String name;
    double price;
    int expYear, expMonth, expDay; // keep it basic

    GroceryItem(String name, double price, int y, int m, int d) {
        this.name = name; this.price = price; this.expYear = y; this.expMonth = m; this.expDay = d;
    }

    boolean isExpired(int todayY, int todayM, int todayD) {
        if (todayY > expYear) return true;
        if (todayY < expYear) return false;
        if (todayM > expMonth) return true;
        if (todayM < expMonth) return false;
        return todayD > expDay;
    }
}

// 39. CreditCard
class CreditCard {
    String number;
    double balance;
    double limit;

    CreditCard(String number, double limit) { this.number = number; this.limit = limit; }

    boolean purchase(double amount) {
        if (amount <= 0) return false;
        if (balance + amount > limit) return false;
        balance += amount; return true;
    }

    void printStatement() {
        System.out.println("Card ****" + number.substring(number.length()-4) + ", Balance: $" + balance);
    }
}

// 40. MusicTrack
class MusicTrack {
    String title; String artist; int seconds;
    MusicTrack(String title, String artist, int seconds) { this.title = title; this.artist = artist; this.seconds = seconds; }
    boolean longerThan(MusicTrack other) { return this.seconds > other.seconds; }
}

// 41. Quiz
class Quiz {
    String question;
    String[] options;
    int correctIndex;

    Quiz(String question, String[] options, int correctIndex) {
        this.question = question; this.options = options; this.correctIndex = correctIndex;
    }

    String check(int answerIndex) {
        if (answerIndex == correctIndex) return "Correct";
        return "Incorrect. Correct: " + options[correctIndex];
    }
}

// 42. JournalEntry
class JournalEntry {
    String title; String date; String content; // keep date as String
    JournalEntry(String title, String date, String content) { this.title = title; this.date = date; this.content = content; }
    String summary() { return content.length() <= 100 ? content : content.substring(0, 100) + "..."; }
}

// 43. PetAdoption
class PetAdoption {
    String petName; String type; boolean adopted;
    PetAdoption(String petName, String type) { this.petName = petName; this.type = type; }
    void finalizeAdoption() { adopted = true; }
}

// 44. TravelItinerary
class TravelItinerary {
    String destination; int startDay; int endDay; // pretend same month
    TravelItinerary(String destination, int startDay, int endDay) { this.destination = destination; this.startDay = startDay; this.endDay = endDay; }
    int durationDays() { return endDay - startDay; }
    void printSummary() { System.out.println("Trip to " + destination + ": " + durationDays() + " days"); }
}

// 45. ToDoTask
class ToDoTask {
    String name; int priority; boolean done; // 1 low, 2 med, 3 high
    ToDoTask(String name, int priority) { this.name = name; this.priority = priority; }
    void markDone() { done = true; }
    static ToDoTask[] highPriority(ToDoTask[] tasks) {
        // return only high & not done (simple fixed-size copy)
        ToDoTask[] result = new ToDoTask[tasks.length];
        int idx = 0;
        for (int i = 0; i < tasks.length; i++) {
            if (tasks[i] != null && tasks[i].priority == 3 && !tasks[i].done) {
                result[idx++] = tasks[i];
            }
        }
        return result; // may contain nulls at the end
    }
}

// 46. PaintJob
class PaintJob {
    double length, width, height, costPerSqFt;
    PaintJob(double l, double w, double h, double cost) { length=l; width=w; height=h; costPerSqFt=cost; }
    double estimate() { double wallArea = 2 * (length + width) * height; return wallArea * costPerSqFt; }
}

// 47. Fan
class Fan {
    int speed; // 0–3
    String mode = "Normal";
    boolean on;
    void togglePower() { on = !on; }
    void setSpeed(int s) { if (s>=0 && s<=3) speed = s; }
    void setMode(String m) { mode = m; }
}

// 48. HealthProfile
class HealthProfile {
    String name; int age; double weightKg; double heightM;
    HealthProfile(String name, int age, double weightKg, double heightM) { this.name=name; this.age=age; this.weightKg=weightKg; this.heightM=heightM; }
    double bmi() { return weightKg / (heightM * heightM); }
    String bmiCategory() {
        double b = bmi();
        if (b < 18.5) return "Underweight";
        if (b < 25) return "Normal";
        if (b < 30) return "Overweight";
        return "Obese";
    }
}

// 49. TaxiRide
class TaxiRide {
    double distanceKm, ratePerKm; String passenger;
    TaxiRide(double d, double r, String p) { distanceKm=d; ratePerKm=r; passenger=p; }
    double fare() { return distanceKm * ratePerKm; }
    void printReceipt() { System.out.println(passenger + ": $" + fare()); }
}

// 50. Timer (recursive countdown printing)
class Timer {
    int seconds;
    Timer(int seconds) { this.seconds = seconds; }
    void start() { countdown(seconds); }
    void countdown(int s) {
        System.out.println("T-" + s);
        if (s == 0) return;
        countdown(s - 1);
    }
}

// 51. FitnessClass
class FitnessClass {
    String name; int capacity; int enrolled;
    FitnessClass(String name, int capacity) { this.name=name; this.capacity=capacity; }
    boolean enroll() { if (enrolled >= capacity) return false; enrolled++; return true; }
    boolean hasSpace() { return enrolled < capacity; }
}

// 52. Donation
class Donation {
    String donor; double amount; String category;
    Donation(String donor, double amount, String category) { this.donor=donor; this.amount=amount; this.category=category; }
    boolean receiptEligible() { return amount >= 20; }
    void printSummary() { System.out.println(donor + " donated $" + amount + " to " + category + ". Receipt: " + receiptEligible()); }
}

// 53. BadgeAccess
class BadgeAccess {
    String badgeId; String userName; int accessLevel; // 1–5
    BadgeAccess(String badgeId, String userName, int accessLevel) { this.badgeId=badgeId; this.userName=userName; this.accessLevel=accessLevel; }
    boolean valid() { return badgeId != null && badgeId.startsWith("BAD-") && badgeId.length() == 8; }
    boolean canOpen(int doorLevel) { return valid() && accessLevel >= doorLevel; }
}

// 54. Plant
class Plant {
    String species; String sunlight; int waterEveryDays;
    Plant(String species, String sunlight, int days) { this.species=species; this.sunlight=sunlight; this.waterEveryDays=days; }
    void showCare() { System.out.println(species + ": " + sunlight + ", water every " + waterEveryDays + " days"); }
}

// 55. Keyboard
class Keyboard {
    String layout; String brand; boolean backlight;
    Keyboard(String layout, String brand, boolean backlight) { this.layout=layout; this.brand=brand; this.backlight=backlight; }
    void toggleLight() { backlight = !backlight; }
    void test(String text) { System.out.println("[" + brand + " " + layout + (backlight?" BL-ON":" BL-OFF") + "] " + text); }
}

// 56. MarketplaceListing
class MarketplaceListing {
    String item; double price; String seller; boolean available = true;
    MarketplaceListing(String item, double price, String seller) { this.item=item; this.price=price; this.seller=seller; }
    void updatePrice(double p) { if (p > 0) price = p; }
    void toggle() { available = !available; }
}

// 57. TicketBooking
class TicketBooking {
    String seat, section, event; boolean reserved;
    TicketBooking(String seat, String section, String event) { this.seat=seat; this.section=section; this.event=event; }
    boolean reserve() { if (reserved) return false; reserved = true; return true; }
    boolean cancel() { if (!reserved) return false; reserved = false; return true; }
}

// 58. Medication
class Medication {
    String name; String dosage; int timesPerDay; int pillsLeft;
    Medication(String name, String dosage, int timesPerDay, int pillsLeft) { this.name=name; this.dosage=dosage; this.timesPerDay=timesPerDay; this.pillsLeft=pillsLeft; }
    void showDailySchedule() {
        int interval = 24 / Math.max(1, timesPerDay);
        for (int h = 0; h < 24; h += interval) {
            System.out.println(String.format("%02d:00 - %s %s", h, name, dosage));
        }
    }
    boolean needsRefill() { return pillsLeft < timesPerDay * 7; }
}

// 59. ChessGame
class ChessGame {
    String white, black;
    String lastMove = ""; // keep it simple
    String winner = "";   // "White"/"Black"/"Draw"/""

    ChessGame(String white, String black) { this.white=white; this.black=black; }
    void makeMove(String algebraic) { lastMove = algebraic; }
    void setWinner(String w) { winner = w; }
    void printState() { System.out.println(white + " vs " + black + ", last: " + lastMove + ", winner: " + (winner.equals("")?"TBD":winner)); }
}

// 60. MobileApp
class MobileApp {
    String name; String version; String dev; String lastChange = "";
    MobileApp(String name, String version, String dev) { this.name=name; this.version=version; this.dev=dev; }
    void update(String newVersion, String notes) { version = newVersion; lastChange = notes; }
    void showInfo() { System.out.println(name + " v" + version + " by " + dev + (lastChange.equals("")?"":" ("+lastChange+")")); }
}


