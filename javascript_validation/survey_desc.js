function validation() {
    var name = document.getElementById('name').value;
    var cat = document.getElementById('drop1').value;
    var desc = document.getElementById('desc').value;
    // var created_by = document.getElementById('created_by').value;
    var created_date = document.getElementById('date').value;
    var end_date = document.getElementById('date1').value;
    // document.write(name);


    // ***********************

    var errorflag = true;

    // ***********************

    // Emptying all the spans 

    // Name Span
    var error_name = "";
    $('#nameprompt').html("");

    $('#catprompt').html("");
    $('#descprompt').html("");
    $('#dateprompt').html("");
    $('#dateprompt1').html("");


    // ***********************

    // Validations 

    // Name
    if (name == "") {
        error_name += "**enter survey name<br>";
        // $('#nameprompt').html("**enter your name<br>");  
        errorflag = false;
    }
    if (error_name != '') {
        $('#nameprompt').html(error_name);  
    }


    if (cat == "") {
        $('#catprompt').html("**enter survey Category<br>");  
        errorflag = false;
    }

    if (desc == "") {
        $('#descprompt').html("**enter survey description<br>");  
        errorflag = false;
    }

    if (created_date == "") {
        $('#dateprompt').html("**enter date<br>");  
        errorflag = false;
    }

    if (end_date == "") {
        $('#dateprompt1').html("**enter date<br>");  
        errorflag = false;
    }

    return errorflag;
}