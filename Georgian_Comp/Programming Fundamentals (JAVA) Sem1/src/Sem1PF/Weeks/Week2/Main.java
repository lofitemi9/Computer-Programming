public class Main {

    public static void main(String[] args) {
		System.out.println("Hello World");
		int age = 25;
		// an integer variable holds a whole number value
		//declaring a variable includes data type -> name -> equal sign -> value
		//double data types store values with decimal numbers
		double salary = 50000.75;
		//character will be stored in char data type
		char grade = 'A';
		//boolean data type stores true or false values
		boolean javaisFun = true;
		
		System.out.println("Age" + age);
		System.out.println("Salary: " + salary);
		System.out.println("Grade" + grade);
		System.out.println("Is Java Fun" + javaisFun);
		
		//basic mathematical operations
		int num1 = 10;
		int num2 = 3;
		System.out.println("Addition: "+ num1 + " + " + num2 + "=" + (num1+num2));
		System.out.println("Subtraction: "+ num1 + " - " + num2 + " = " + (num1-num2));
		System.out.println("Subtraction: "+ num1 + " * " + num2 + " = " + (num1*num2));
		System.out.println("Subtraction: "+ num1 + " / " + num2 + " = " + (num1/num2));
		System.out.println("Subtraction: "+ num1 + " % " + num2 + " = " + (num1%num2));
		
		//relational operators; greater than, less than
		System.out.println("is number 1 greater than number 2? " + (num1>num2));
		System.out.println("is number 1 less than number 2? " + (num1<num2));
		System.out.println("is number 1 equal than number 2? " + (num1==num2));
		
		
		//logical operators: AND, OR, NOT
		boolean isGreater = num1>num2;
		boolean isLess = num1<num2;
		System.out.println("is num1 greater AND less than num2?"+ (isGreater && isLess));
		System.out.println("is num1 greater OR less than num2" + (isGreater || isLess));
		System.out.println("is num1 NOT greater than num2" + (!isGreater)); 
		
		
		String greeting = "Hello World";
		System.out.println("The length of the string is "+ greeting.length());
		System.out.println("First Character: "+ greeting.charAt(0));
		System.out.println("Substrings: "+ greeting.substring(num2, num1));
		System.out.println("Concatenated: "+ greeting.concat(" my friend."));
		System.out.println("Uppercase "+ greeting.toUpperCase());
		System.out.println("Uppercase "+ greeting.toLowerCase());
		
		
		int num3 = -4;
		if (num3 > 0) {
			System.out.println("The number is Positive");
			System.out.println("Great Number");
		}
		else {
			System.out.println("The number is Negative");
			}
		
		int gradeb = 57;
		if (gradeb > 90)
			System.out.print("Letter grade is A");
		else if (gradeb > 80)
			System.out.print("Letter grade is B");
		else if (gradeb > 70)
			System.out.print("Letter grade is C");
		else if (gradeb > 70)
			System.out.print("Letter grade is D");
		else 
			System.out.print("Letter grade is F");
		
		
		
		
		
		
		
    }
}
