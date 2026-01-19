    /* STEP 1: Creating Strings */
    let step1a = 'This is "a" string';
    output.textContent = step1a;
    let step1b = "This is a string";
    output.textContent = step1b;
    
    // Note - whether you use 'single' or "double" quotes is a personal preference - try to be consistent

    /* STEP 2: Escaping Characters */
    let step2a = r("It's six o ' clock");
    output.textContent = step2a;
    
    /* STEP 3: Concatenation */
    let step3a = 'Javascript';
    let step3b = 'rocks';
    output.textContent = step3a + ' ' + step3b;

    /* STEP 4: Numbers and Strings */
    let step4a = 'Fahrenheit' + 543;
    output.textContent = step4a + ' ' + typeof(step4a);

    // strings can be converted to numbers, too
    let step4b = Number('20') + Number('18');
    output.textContent = step4b = ' ' + typeof(step4b);
    // and back again, if we want 

    
    // numbers can be converted to strings
    let step4c = step4b.toString()
    output.textContent = step4c = ' ' + typeof(step4c);