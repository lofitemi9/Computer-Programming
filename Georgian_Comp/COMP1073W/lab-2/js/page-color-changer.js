// this getst he slkiders fro mthe html
const redSlider = document.getElementById("red");
const greenSlider = document.getElementById("green");
const blueSlider = document.getElementById("blue");


// get the page background
const page = document.body;


function changeBackgroundColor() {
    // Get slider values
    const red = redSlider.value;
    const green = greenSlider.value;
    const blue = blueSlider.value;

    // build the RGB color string
    const rgbColor = `rgb(${red}, ${green}, ${blue})`;

    // apply the background color
    page.style.backgroundColor = rgbColor;
}


// ruun function when sliders change
redSlider.addEventListener("input", changeBackgroundColor);
greenSlider.addEventListener("input", changeBackgroundColor);
blueSlider.addEventListener("input", changeBackgroundColor);
