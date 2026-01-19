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

//Select a random Type from petArray
petType = petArray[Math.floor(Math.random() * petArray.length)]

//Collect petName from nameField
petName = document.querySelector("#nameField")

// Check if petName has been submitted
let submitNameField = document.querySelector("#submitName")
submitNameField.addEventListener("click", function () {
    updateUI();
});

// Collect hunger checkbox
isHungry = document.querySelector("#hungryField");

// Check if hunger status has been submitted 
let submitHungerField = document.querySelector("#submitHunger")
submitHungerField.addEventListener("click", function () {
    updateUI();
});


// These are the fields where output is gonna go
let petNameField = document.querySelector("#petName");
let petAgeField = document.querySelector("#petAge");
let petTypeField = document.querySelector("#petType");
let petHungerField = document.querySelector("#petHunger");

// defining a function that updates the pet info on the page
function updateUI() {
    petNameField.textContent = "Your Pets Name is: " + petName.value;
    petAgeField.textContent = "Your Pets Age is: " + petAge;
    petTypeField.textContent = "Your Pet is a: " + petType;
    petHungerField.textContent = "Your pet is hungry: " + isHungry.checked;
}

// creating the petAge system to either increase or decrease the pets Age
    // assigning the button to values
    const increasePetAge = document.querySelector('#increaseAgeField');
    const decreasePetAge = document.querySelector('#decreaseAgeField');

    // conditional system to check if button has been clicked or not
    increasePetAge.addEventListener("click", function () {
        // updating age to increase by 1 when button clicked
        petAge += 1;
        console.log(petAge)
        updateUI();

    });
        // updating age to decrease by 1 when button clicked
    decreasePetAge.addEventListener("click", function () {
        if (petAge > 0) {
            petAge -= 1;}
        console.log(petAge) 
        updateUI()
    })

// Show information content
    updateUI()






