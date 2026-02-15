const part1 = ["The turkey", "Mom", "Dad", "The dog", "My teacher", "The elephant", "The cat"];
const part2 = ["sat on", "ate", "danced with", "saw", "doesn't like", "kissed"];
const part3 = ["a funny", "a scary", "a goofy", "a slimy", "a barking", "a fat"];
const part4 = ["goat", "monkey", "fish", "cow", "frog", "bug", "worm"];
const part5 = ["on the moon.", "on the chair.", "in my spaghetti.", "in my soup.", "on the grass.", "in my shoes."];

let i1 = 0, i2 = 0, i3 = 0, i4 = 0, i5 = 0;

const val1 = document.getElementById("val1");
const val2 = document.getElementById("val2");
const val3 = document.getElementById("val3");
const val4 = document.getElementById("val4");
const val5 = document.getElementById("val5");

const btn1 = document.getElementById("btn1");
const btn2 = document.getElementById("btn2");
const btn3 = document.getElementById("btn3");
const btn4 = document.getElementById("btn4");
const btn5 = document.getElementById("btn5");

function updateUI() {
  val1.textContent = part1[i1];
  val2.textContent = part2[i2];
  val3.textContent = part3[i3];
  val4.textContent = part4[i4];
  val5.textContent = part5[i5];
}

// still just testing clicks for now
btn1.addEventListener("click", () => console.log("btn1 clicked"));
btn2.addEventListener("click", () => console.log("btn2 clicked"));
btn3.addEventListener("click", () => console.log("btn3 clicked"));
btn4.addEventListener("click", () => console.log("btn4 clicked"));
btn5.addEventListener("click", () => console.log("btn5 clicked"));

updateUI();
