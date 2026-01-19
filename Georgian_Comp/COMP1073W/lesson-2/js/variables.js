/* STEP 1: Declare variables
		Use a-z, 0-9, A-Z and underscores, avoiding reserved names
		All program variables are generally declared at the beginning */
        let myName;
        let myAge;
        let string;
        let para = document.querySelector('p')

		/* STEP 2: Initialize variables
		Don't confuse a variable with no value with one that doesn't exist at all */
        myName = 'Shivali Dhaka';
        myAge = 30;

		/* STEP 3: Updating variables
		Once a variable has been declared, this can be done any time */
        myName = 'Shivi';
        myAge = 31;
        string - myName + ' ' + myAge;
        para.textContent = string;

		// STEP 4: Variable types (use typeof in the console)
		// Numbers
        let numCourse = 0;
        para.textContent = numCourse;
        console.log(typeof(numCourse));


		// Strings (use '' or "")
        let stringCourse = 'Client Side JS';
        para.textContent += stringCourse;

		// Booleans
        let iAmAlive = true;
        let compare = 5 < 2;
        para.textContent = iAmAlive;
        console.log('The result of comparison is: ', compare);

		// Arrays
        let myArray = ['Sarah','Steve','Shivi'];
        para.textContent = myArray[1];

        let myArray2 = [20,30,40];
        para.textContent = myArray[2];
		
		// Objects
        let myDog = {fName: 'Simba', breed:'staffy', color:'brown'};
        console.log(myDog.fName);

		// STEP 5: Typing (JavaScript is a loosely-typed language)
        let myNumber = 300;
        console.log(typeof(myNumber));
        myNumber = false;
        console.log(typeof(myNumber));


//Difference between Var and Let

//1. Scope
function testscope() {
    if(true) {
        var a = 10; //function-scoped variable
    }
    console.log(a);

    if(true) {
        let b = 20;
        console.log(b); //block-scoped variable
    }
    // console.log(b);
}

testscope(); 

//2. Re-declaration
function demo(){
    //Hoisting with var
    console.log('value of x before declaration', x)
    var x = 10;

    //Hoisting with let
    console.log('value of y before declaration', y)
    let y = 11;

    //Redeclaration with var
    var a = 15;
    var a = 20;
    console.log("Redeclared var a: ", a);

    // Redeclaration with let

    let b = 10;
    // let b = 20;
    console.log('Redeclared let b: ', b);
        console.log(c);
        const c = 10;
        // c = 20;


}
demo();