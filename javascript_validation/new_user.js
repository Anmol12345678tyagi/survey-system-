function validate() {
    var name = document.getElementById('name').value;
    var email = document.getElementById('email').value;
    var pass = document.getElementById('password').value;
    var conf_password = document.getElementById('conf_password').value;
    var dob = document.getElementById('dob').value;
    var gender = document.getElementById('drop1').value;
    var phone = document.getElementById('id_phone').value;

    // ***********************

    // Regular Expressions

    // Test Cases For Name
    var user_test_1 = /[0-9]/;
    var user_test_2 = /[~`!@#$%^&*()\[\]\\.,;:@"\-\\_+={}<>?]/;

    //  Test Cases For Email
    var email_test_0 = /^[A-z0-9_.-]+@[a-z]+[.][a-z]{2,3}$/;
    // var email_test_1 = /^[A-z0-9_.-]/;
    // var email_test_2 = /@/g;
    // var email_test_3 = /@[a-z]/;
    // var email_test_4 = /[.][a-z]$/;

    // var pattern = email.match(email_test_2);


    // Test Cases For Password
    var pass_test_1 = /[A-Z]/;
    var pass_test_2 = /[a-z]/;
    var pass_test_3 = /[0-9]/;
    var pass_test_4 = /[~`!@#$%^&*()\[\]\\.,;:\s@"\-\\_+={}<>?]/;

    // ***********************

    var errorflag = true;

    // ***********************

    // Emptying all the spans 

    // Name Span
    var error_name = "";
    $('#nameprompt').html("");

    // // Email Span
    var error_email = "";
    $('#emailprompt').html("");

    // // Password Span
    var error_pass = "";
    $('#passwordprompt').html("");

    // // Cofirm Password Span
    var error_conpass = "";
    $('#con_passwordprompt').html("");

    $('#dobprompt').html("");
    $('#genderprompt').html("");
    $('#phoneprompt').html("");

    // ***********************

    // Validations 

    // Name
    if (name == "") {
        error_name += "**Please enter your name<br>";
        // $('#nameprompt').html("**Please enter your name<br>");  
        errorflag = false;
    }
    else {
        if (user_test_1.test(name)) {
            error_name +="**Name can not contain numbers <br>";
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
        // $('#emailprompt').html("**Please enter your email<br>");  
        error_email += "**Please enter your email";
        errorflag = false;
    }
    else if(!(email_test_0.test(email))){
        error_email = error_email + "**Invalid email format  <br>";
        errorflag = false;
    }
    // else {
    //     if (!(email_test_1.test(email))) {
    //         error_email = error_email + "**Missing text before @ symbol. <br>";
    //         errorflag = false;
    //     }
    //     if (!(email_test_2.test(email))) {
    //         error_email = error_email + "**Missing @ symbol. <br>";
    //         errorflag = false;
    //     }
    //     if (pattern.length > 1) {
    //         error_email = error_email + "**Multiple @ not allowed. <br>";
    //         errorflag = false;
    //     }
    //     if (!(email_test_3.test(email))) {
    //         error_email = error_email + "**Missing text after @ symbol. <br>";
    //         errorflag = false;
    //     }
    //     if (!(email_test_4.test(email))) {
    //         error_email = error_email + "**Missing .com or .in at the end. <br>";
    //         errorflag = false;
    //     }
    // }
    if (error_email != '') {
        $('#emailprompt').html(error_email);
    }

    // // Password
    if (pass == "") {
        $('#passwordprompt').html("**Please enter your password<br>");  
        errorflag = false;
    }
    else {
        if ((pass.length < 7 || pass.length > 20)) {
            error_pass = error_pass + "**Password must be between 7 and 20 characters in length.<br>";

            errorflag = false;
        }
        if (!(pass_test_1.test(pass))) {
            error_pass = error_pass + "**Must contain an uppercase letter.<br>";
            errorflag = false;
        }
        if (!(pass_test_2.test(pass))) {
            error_pass = error_pass + "**Must contain a lowercase letter.<br>";
            errorflag = false;
        }
        if (!(pass_test_3.test(pass))) {
            error_pass = error_pass + "**Must contain a digit.<br>";
            errorflag = false;
        }
        if (!(pass_test_4.test(pass))) {
            error_pass = error_pass + "**Must contain a special symbol.<br>";
            errorflag = false;
        }
    }
    if (error_pass != '') {
        $('#passwordprompt').html(error_pass);
    }

    // // Confirm Password
    if (conf_password == "") {
        error_conpass += "**Please enter your confirm password<br>";
        errorflag = false;
    }
    else if (pass != conf_password) {
        error_conpass += "**Password did not match<br>";
        errorflag = false;
    }
    if (error_conpass != '') {
        $('#con_passwordprompt').html(error_conpass);
    }

    if (dob == "") {
        $('#dobprompt').html("**Please enter your dob<br>");  
        errorflag = false;
    }

    if (gender == "") {
        $('#genderprompt').html("**Please select your gender<br>");  
        errorflag = false;
    }

    if (phone == "") {
        $('#phoneprompt').html("**Please enter your phone number<br>");  
        errorflag = false;
    }

    return errorflag;
}