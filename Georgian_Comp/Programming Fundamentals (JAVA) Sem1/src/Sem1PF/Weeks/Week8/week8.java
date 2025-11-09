public class week8 {
    public static void main(String[] args) {
        String greeting = "Hello Java";
        System.out.println("Original String " + greeting);

        System.out.println("Length of the string " + greeting.length());
        System.out.println("First Character " + greeting.charAt(0));
        System.out.println("Last Character " + greeting.charAt(greeting.length()-1));

        String name = "Alice";
        String fullGreeting = greeting.concat("Welcome, ").concat(name);
        System.out.println("Concatenated string: " + fullGreeting);

        String str1 = "Java";
        String str2 = "Java";
        String str3 = new String("Java");

        System.out.println("str1 == str2: " + (str1 == str2));
        System.out.println("str1 == str3: " + (str1 == str3));

        System.out.println("str1.equals(str2): " + str1.equals(str2));
        System.out.println("str1.equals(str3): " + str1.equals(str3));

        String message = "Hello, World!";
        
        String part = message.substring(0,5);
        System.out.println("Substring: " + part);
        
        System.out.println("Uppercase: " + message.toUpperCase());
        System.out.println("Lowercase: " + message.toLowerCase());

        // String Builder
        String str = "Hello";
        str += ", Java";
        System.out.println("Using String: " + str);

        StringBuilder sb = new StringBuilder("Hello");
        sb.append(", Java!");
        System.out.println("Using StringBuilder: " + sb.toString());
        sb.insert(5, "Awesome");
        System.out.println("After insert method: " + sb.toString());

        sb.reverse();
        System.out.println("Reversed: " + sb.toString()); 

        String input = "madam";
        boolean isPalindrome = true;
        for(int i=0; i<input.length()/2; i++){
            if (input.charAt(i) != input.charAt(input.length() -i - 1)){
                isPalindrome = false;
                break;
            }

        }

        if (isPalindrome){
            System.out.println(input + " is a palindrome.");
        }
        else{
            System.out.println(input + " is not a palindrome.");
        }

        String myStr = "";
        System.out.println("myStr is Empty: " + myStr.isEmpty());

        String myStr2 = " ";
        System.out.println("myStr2 is: " + myStr2.isBlank());

        String str5 = "Java";
        String str4 = "java";
        System.out.println("str5.equalsIgnoreCase(str4): " + str5.equalsIgnoreCase(str4));
        System.out.println("str5.compareTo(str4): " + str5.compareTo(str4));
        System.out.println("str5.compareToIgnoreCase(str4): " + str5.compareToIgnoreCase(str4));

        System.out.println("str5.startswith(Ja): " + str5.startsWith("Ja"));
        System.out.println("str5.endsWith(VA)" + str5.endsWith("VA"));
        
        System.out.println("str5.contains(es): " + str5.contains("es"));

        System.out.println("str5.trim(): " + str5.trim());

    }

}
