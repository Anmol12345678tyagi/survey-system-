function validateform() {

    var errorflag = true;

    var name = document.getElementById('name').value;
    var email = document.getElementById('email').value;
    var subject = document.getElementById('subject').value;
    var message = document.getElementById('message').value;

     // Regular Expressions

     // Test Cases For Name
    var user_test_1 = /[0-9]/;
    var user_test_2 = /[~`!@#$%^&*()\[\]\\.,;:@"\-\\_+={}<>?]/;

    //  Test Cases For Email
    var email_test_0 = /^[A-z0-9_.-]+@[a-z]+[.][a-z]{2,3}$/;


    // Emptying all the spans 

    // Name Span
    var error_name = "";
    $('#nameprompt').html("");

     // Email Span
    var error_email = "";
    $('#emailprompt').html("");

    $('#subjectprompt').html("");
    $('#messageprompt').html("");

    // ***********************

 // Validations 

    // Name
    if (name == "") {
        error_name += "**Please enter your name<br>";
        errorflag = false;
    }
    else {
        if (user_test_1.test(name)) {
            error_name += "**Name can not contain numbers <br>";
            errorflag = false;
        }
        if (user_test_2.test(name)) {
            error_name += "**Name can not contain symbols <br>";
            errorflag = false;
        }
    }

    if (error_name != '') {
        $('#nameprompt').html(error_name);
    }

    // Email
    if (email == "") {
        error_email += "**enter your email";
        errorflag = false;
    }
    else if (!(email_test_0.test(email))) {
        error_email = error_email + "**Invalid email format  <br>";
        errorflag = false;
    }

    if (error_email != '') {
        $('#emailprompt').html(error_email);
    }

    // subject
    if (subject == "") {
        $('#subjectprompt').html("**enter subject<br>");
        errorflag = false;
    }

    // message
    if (message == "") {
        $('#messageprompt').html("**enter message<br>");  
        errorflag = false;
    }

    return errorflag;
}