const output = document.querySelector('body p:nth-of-type(2)');

/* STEP 1: Creating an array
When declaring and initializing an array, you can include strings, numbers, booleans, and even other arrays */

let myArray = ['string',25,true,[10,20,30]]
output.textContent = myArray;

/* STEP 2: Reading and changing array elements
You can refer to a particular element in an array with it's index number */

output.textContent = myArray[2];
output.textContent = myArray[3][1];

// You can also change a particular element

// An array within an array is called a multidimensional array - it can be accessed by specifying the index of the first array, then the item within it
/* STEP 3: Determining array length
Being able to figure out how many elements are contained in an array is a critical feature of JavaScript programming */
output.textContent = myArray.length;

// In particular, looping through arrays

for(let i=0; i<myArray.length; i++){
    console.log(myArray[i])
    output.textContent +=', ' + myArray[i]
}

// forEach loop : is an array method used to execute a function once for each element in an array

myArray.forEach(function(item){
    console.log(item);
    output.textContent += ', ' + item;
});

// Arrow function : is a shorter to write a function in JS

// ForEach using Arrow function
myArray.forEach(item => {
console.log(item);
    output.textContent += ', ' + item
});

/* STEP 4: Convert a string to an array
If there is a common character that can act as a delimiter in a string, we can use this character to create an array */

let origFive = 'Toronto Maple Leafs, Chicago Black Hawks, Detroit Red Wings, Boston Bruins, Montreal Canadians';
console.log(origFive)

let origFiveArray = origFive.split(', ');
console.log(origFiveArray)

// Output one of the array items

output.textContent = origFiveArray[2];

// Output the last element of the array

output.textContent = origFiveArray[origFiveArray.length-1];

/* STEP 5: Convert an array back to a string
Use join() and toString() - note that join() allows you to choose and insert a delimiter, while toString() does not */

let origFiveString = origFiveArray.join('-');
output.textContent = origFiveString;

let origFiveString2 = origFiveArray.toString();
output.textContent = origFiveString2;
/* STEP 6: Adding and removing items from an array
Without the ability to edit the contents of an array, this type of variable would have limited use - but adding and removing array items is pretty straightforward */

// Adding one or more items to an array with push()

let origSevenArray = origFiveArray.push('Network Rangers', 'Philadelphia Flyers')
output.textContent = origSevenArray;

// If you would like to capture how many elements are in the array after you have edited it, then…

output.textContent = origSevenArray + 'items and they are ' + origFiveArray;
// Removing an item from an array with pop()
output.textContent == origFiveArray.pop()


// pop() returns the item that was removed, rather than the length of the updated array, so…

// To do the same thing, that is, to add and remove an item from the beginning of the array, use shift() and unshift()
origSevenArray = origFiveArray.unshift("Buffalo Sabres");
output.textContent = origSevenArray;
output.textContent = origFiveArray;

output.textContent = origFiveArray.shift();
output.textContent = origFiveArray;

// map(): is used to change each element and return a new array

let mappedArray = myArray.map(item => String(item));
console.log('Mapped Array is: ' + mappedArray);
console.log(typeof(mappedArray));

// filter : select specific elements; keeps elements that match a condition
let numbersOnly = myArray.filter(item => typeof item === 'number');
console.log(numbersOnly);

// includes() : checks if a value exists; returns true or false

console.log(myArray.includes(25));
console.log(myArray.includes(false));


// We can also modify the array contents by deleting or substituting elements, or inserting one or more elements at a certain place with splice()

/* That's it for the basics of working with arrays! With these tools at your disposal, a whole new world of possibilities with JavaScript are at your command */