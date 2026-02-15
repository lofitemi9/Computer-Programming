/*
  See 'N' Say Storymaker - Web Version
  - 5 buttons cycle through arrays
  - "Tell my story" outputs the combined sentence
  - Random + Reset + Optional Audio
*/

// -----------------------------
// Sentence Arrays
// -----------------------------
const part1 = ["The turkey", "Mom", "Dad", "The dog", "My teacher", "The elephant", "The cat"];
const part2 = ["sat on", "ate", "danced with", "saw", "doesn't like", "kissed"];
const part3 = ["a funny", "a scary", "a goofy", "a slimy", "a barking", "a fat"];
const part4 = ["goat", "monkey", "fish", "cow", "frog", "bug", "worm"];
const part5 = ["on the moon.", "on the chair.", "in my spaghetti.", "in my soup.", "on the grass.", "in my shoes."];

// -----------------------------
// State (current selection indexes)
// -----------------------------
let i1 = 0, i2 = 0, i3 = 0, i4 = 0, i5 = 0;

// -----------------------------
// DOM Elements
// -----------------------------
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

const tellStoryBtn = document.getElementById("tellStoryBtn");
const randomBtn = document.getElementById("randomBtn");
const resetBtn = document.getElementById("resetBtn");

const storyText = document.getElementById("storyText");
const audioToggle = document.getElementById("audioToggle");

// -----------------------------
// Helper Functions
// -----------------------------

// Update visible button labels
function updateUI() {
  val1.textContent = part1[i1];
  val2.textContent = part2[i2];
  val3.textContent = part3[i3];
  val4.textContent = part4[i4];
  val5.textContent = part5[i5];
}

// Cycle index safely
function cycleIndex(current, length) {
  return (current + 1) % length;
}

// Build full sentence
function buildStory() {
  return `${part1[i1]} ${part2[i2]} ${part3[i3]} ${part4[i4]} ${part5[i5]}`;
}

// Output story + optional audio
function showStory(text) {
  storyText.textContent = text;

  if (audioToggle.checked && "speechSynthesis" in window) {
    window.speechSynthesis.cancel();
    const utter = new SpeechSynthesisUtterance(text);
    window.speechSynthesis.speak(utter);
  }
}

// -----------------------------
// Event Listeners
// -----------------------------

btn1.addEventListener("click", () => {
  i1 = cycleIndex(i1, part1.length);
  updateUI();
});

btn2.addEventListener("click", () => {
  i2 = cycleIndex(i2, part2.length);
  updateUI();
});

btn3.addEventListener("click", () => {
  i3 = cycleIndex(i3, part3.length);
  updateUI();
});

btn4.addEventListener("click", () => {
  i4 = cycleIndex(i4, part4.length);
  updateUI();
});

btn5.addEventListener("click", () => {
  i5 = cycleIndex(i5, part5.length);
  updateUI();
});

// Tell story
tellStoryBtn.addEventListener("click", () => {
  showStory(buildStory());
});

// Random story
randomBtn.addEventListener("click", () => {
  i1 = Math.floor(Math.random() * part1.length);
  i2 = Math.floor(Math.random() * part2.length);
  i3 = Math.floor(Math.random() * part3.length);
  i4 = Math.floor(Math.random() * part4.length);
  i5 = Math.floor(Math.random() * part5.length);

  updateUI();
  showStory(buildStory());
});

// Reset
resetBtn.addEventListener("click", () => {
  i1 = 0; i2 = 0; i3 = 0; i4 = 0; i5 = 0;
  updateUI();

  if ("speechSynthesis" in window) {
    window.speechSynthesis.cancel();
  }

  storyText.textContent = "Click the buttons to build a story…";
});

// Initialize UI on load
updateUI();
