/* STEP 1: Basic browser functions
There are a number of functions that are included with most modern browsers - the replace() function is just one of many */
let text = 'Functions are assets';
let newText= text.replace('assets','awsome');
console.log(newText);

// Interestingly, functions that are included with your browser are technically called 'methods' rather than functions.
function makeH1Red(){
    var globalVariable = 'I am a global variable';
    const h1 = document.querySelector('h1');
    h1.style.color = 'rgb(0,0,100)';
}

makeH1Red();

/* STEP 2: Anonymous versus named functions */

// Anonymous
const step2Button = document.querySelector('#step2');
// step2Button.onclick = function(){
//     alert('Anonymous Function is called');
// }

// Named function
function Step2Alert(){
    alert('This is a name function');
}

step2Button.onclick = Step2Alert;

/* STEP 3: Function parameters
Some methods or functions don't require any parameters (sometimes called arguments, properties, or attributes), while some do, and others are optional. */

// No parameters needed
let random= Math.random();
console.log(random);


// Two parameters needed
let functionText = 'My random number is X';
let newFunctionText = functionText.replace('X',random);
console.log(newFunctionText);

// Parameters optional
let breakfastArray = ['Bagel','bean','Burrito'];
breakfast = breakfastArray.join('-');
console.log(breakfast);

//Traditional Function
function add(x,y){
    return x + y;
}
let output = add(2,3);
console.log(output);

//Arrow Function
/* const functionName =(param1,param2...)=>{
    //function body
    }  */

    const addArrow=(x,y) => x + y;
    console.log(addArrow(4,5));
    

// Next, open up scope.html and we will look at how the accessibility of variables depends on where they are defined/initialized.

// This page inspired by and adapted from https://developer.mozilla.org/en-US/docs/Learn/JavaScript/Building_blocks/Functions