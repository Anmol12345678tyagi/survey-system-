function validateform() {
    var errorflag = true;

    var email = document.getElementById('emailid').value;
    var pass = document.getElementById('passid').value;

    
    $('#emailprompt').html("");

    var error_pass = "";
    $('#passprompt').html("");

    if(email == ""){
        $('#emailprompt').html("**Please enter email<br>")
            errorflag = false;
    }    
    
    if(pass == ""){
        $('#passprompt').html("**Please enter password<br>")
            errorflag = false;
    } 

    return errorflag;
}