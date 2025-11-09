<?php
    /** 
     * This is how to block comment in PHP
     */
    
    

    echo "<h1>Introduction to web programming using PHP</h1>";

    echo "<h2>1. Variables and Data Types</h2>";
    // A variable is a container for storing data. In PHP, variables start with a $
    $name       = "Temi";
    $age        = 45;
    $is_student = false;
    $pi         = 3.14159;

    // the " . " is the concatenation operator, used to join strings together 
    echo "<p>Hello my name is " . $name . " </p>";
    echo "<p>I am " . $age . " yrs old</p>";

    echo "<h2>2. Conditional Statements</h2>";
    echo "<h3>A simple if statement</h3>";

    $current_time = date("H");
    if ($current_time < 12) {
        echo "<p>Good morning</p>";
    }

    echo "<h3>If else</h3>";
    $temperature = 25;
    if ($temperature > 30) {
        echo "<p>It is too damn hot</p>";
    } else {
        echo "<p>It is not too damn hot</p>";
    }

    echo "<h3>elseif</h3>";
    $grade = 85;
    if ($grade >= 90) {
        echo "<p>Your grade is an A.</p>";
    } elseif ($grade >= 80) {
        echo "<p>Your grade is a B.</p>";
    } else {
        echo "<p>You Shouldn't have back talked the teacher</p>";
    }

    echo "<h2>3. Loops</h2>";
    for ($i = 1; $i <= 5; $i++) {
        echo $i . "<br>";
    }

    $j = 5;
    while ($j >= 1) {
        echo $j . "<br>";
        $j--;
    }

    $fruits = ["Apple", "Banana", "Cherry"];
    foreach ($fruits as $fruit) {
        echo $fruit . "<br>";
    }

    echo "<h3>4. Functions</h3>";
    function sayHello() {
        echo "<p>Hello World</p>";
    }
    sayHello();

    function greet($person) {
        echo "<p>Hello, " . $person . "</p>";
    }
    greet("Bob");

    function addNumbers($num1, $num2) {
        $sum = $num1 + $num2;
        return $sum;
    }
    $result = addNumbers(5, 7);
    echo "<p>The sum of 5 + 7 is: " . $result . "</p>";

    // Bring it all together
    function getDailyMessage() {
        // get the day of week (0 = Sun, 6 = Sat)
        $day_of_week = date("w");
        $message = "";

        if ($day_of_week == 6 || $day_of_week == 0) {
            $message = "<p>It is the weekend have a beer</p>";
        } else {
            $message = "<p>Get to work</p>";
        }
        return $message;
    }
    echo getDailyMessage();

    // this is an array of "Associative arrays"
    $products = [
        ["name" => "Laptop", "price" => 1200],
        ["name" => "Mouse", "price" => 25],
        ["name" => "Keyboard", "price" => 75],
        ["name" => "Monitor", "price" => 300],
    ];

    echo "<h4>Products under 100</h4>";
    foreach ($products as $product) {
        if ($product["price"] < 100) {
            echo "<p>" . $product["name"] . " - " . $product["price"] . "</p>";
        }
    }
?>
