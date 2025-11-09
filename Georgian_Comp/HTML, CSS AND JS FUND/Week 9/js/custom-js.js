// the first thing that we are going to do is make sure that all our html has been rendered
document.addEventListener('DOMContentLoaded', (loaded) => {
    // now we will test to see if our js is connected
    console.log("Our JS Code is Connected");
    // Let's Look at variables
    let a = 200;
    let b = 100;
    let c = a + b;
    // the const is a variable that cannot be changed once thew value has been assigned
    const value1 = 500;
    const value2 = 600;
    let total = value1 + value2;
    // now let's look ath ow wer can add HTML to our already loaded HTML
    document.getElementById("ex1").innerHTML = "<h4>JavaScript Variables</h4>" + "<p>Let: The value of C is " + c + "</p>" + "<p>Const: The toal is: " + total + "</p>";
    // Let's make it pretty
    document.getElementById("ex1").style.color = "#f8f8f8";
    document.getElementById("ex1").style.padding = "0% 10%";
    // now Let's make a global header
    document.getElementById("lesson-global-header").innerHTML = 
        "<div id='logo-container'> " + 
            "<a href='index.html'> " + 
                "<img src = './img/logo.png' id='logo' alt='header logo'> " +
            "</a> " +
            "<nav><menu id= 'main menu'> " + 
                "<li><a href='#'>Link 1</a>" + 
            "</menu></nav>";
            document.getElementById("lesson-global-header").style.cssText = "display: flex; height: 125px; background-color: #f8f8f8; align-items: center;";
});