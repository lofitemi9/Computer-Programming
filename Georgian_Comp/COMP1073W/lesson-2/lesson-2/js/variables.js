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