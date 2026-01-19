// Declaring and initializing variables
let petName;
let petType;
let petAge;
let isHungry;
let favouriteActivities;
let mood;


// Initialize Array
let petArray = ['Dog', 'Cat', 'Fish'];

// Select a random petAge between 1 and 15
petAge = Math.floor(Math.random() * 15) + 1

// Initialize moodArray
let moodArray = ['Happy', 'Sleepy', 'Exicted', 'Grumpy'];

//Select a random mood from the array
mood = moodArray[Math.floor(Math.random() * moodArray.length)]

// creating the petAge system to either increase or decrease the pets Age
    // assigning the button to values
    const increasePetAge = document.querySelector('#increaseAgeField');
    const decreasePetAge = document.querySelector('#decreaseAgeField');

    // conditional system to check if button has been clicked or not
    increasePetAge.addEventListener("click", function () {
        // updating age to increase by 1 when button clicked
        petAge += 1;
        console.log(petAge)

    });
        // updating age to decrease by 1 when button clicked
    decreasePetAge.addEventListener("click", function () {
        if (petAge > 0) {
            petAge -= 1;
            console.log(petAge) } 
    })

// Creating Basic UI to show information content




