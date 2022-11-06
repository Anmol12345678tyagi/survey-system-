<?php 
     $conn = mysqli_connect('localhost','root','','survey');

     if ( isset( $_POST[ 'submit' ] ) ) {
          $name = $_POST[ 'name' ];
          $email = $_POST[ 'email' ];
          $password = ($_POST[ 'password']);       
          $conf_password = ($_POST[ 'conf_password']);
          $phone = $_POST['Phone'];
          $dob = $_POST[ 'dob' ];
          $gender = $_POST['drop_gender'];
          


     //variable****************************

          $msg_name = "";
          $msg_email = "";
          $msg_phone = "";
          $msg_password = "";
          $msg_con_password = "";
          $msg_dob= "";
          $msg_gender = "";

     //pattern*****************************
     $rel_name1 = '/[0-9]/';
     $rel_name2 = '/[~`!@#$%^&*()\[\]\\.,;:@"\-\\_+={}<>?]/';
     $rel_email = '/^[A-z0-9_.-]+[@][a-z]+[.][a-z]{2,3}$/';  
     $relph = '/^\d{10}$/'; 
     $rel_pass1 = '/[A-Z]/'; 
     $rel_pass2 = '/[a-z]/';
     $rel_pass3 = '/[0-9]/';
     $rel_pass4 ='/[~`!@#$%^&*()\[\]\\.,;:\s@"\-\\_+={}<>?]/';

     $flag = true;



     //name********************************
     if($name == ""){
          $msg_name .= "name field is empty <br>";
          $flag = false;
     } 
     else{
          if(preg_match($rel_name1, $name)){
               $msg_name .= "name should not contain numbers <br>";
               $flag = false;
          }
          if(preg_match($rel_name2, $name)){
               $msg_name .= "name should not contain Special Character <br>";
               $flag = false;
          }
     }
     //email*************************************
     if($email == ""){
          $msg_email .= "empty email <br>";
          $flag = false;
     }
     else if(!preg_match($rel_email, $email)){
          $msg_email .= "invalid email <br>";
          $flag = false;
     }
     //PHONE number********************************
     if($phone == ""){
          $msg_phone .= 'empty phone field';
          $flag = false;
     }
     else if(!(preg_match($relph, $phone))){
               $msg_phone .= 'invalid phone';
               $flag = false;
           }
     //password*************************************
     if($password == ""){
          $msg_password .= "empty password";
          $flag = false;
     }
     else{
          if(!preg_match($rel_pass1, $password)){
               $msg_password .= "password must contain at least one upper_case<br>";
               $flag = false;
          }
          if(!preg_match($rel_pass2, $password)){
               $msg_password .= "password must contain at least one lower_case<br>";
               $flag = false;
          }
          if(!preg_match($rel_pass3, $password)){
               $msg_password .= "password must contain at least one numeric char<br>";
               $flag = false;
          }
          if(!preg_match($rel_pass4, $password)){
               $msg_password .= "password must contain at least one special char<br>";
               $flag = false;
          }
          if(strlen($password)<6 || strlen($password)>18){
               $msg_password .= "password length must be 6 to 18<br>";
               $flag = false;
          }
     }
     if($conf_password == ""){
          $msg_con_password .= "empty confirm password";
          $flag = false;
     }
     else if($conf_password != $password){
          $msg_con_password .= "password did not matched";
          $flag = false;
     }
     // dob*******************************
     if($dob == ""){
          $msg_dob .= "empty DOB";
          $flag = false; 
     }
     // // gender****************************
     // if($gender == ""){
     //      $msg_gender .= "empty gender";
     //      $flag = false;
     // }
 
     $query = "SELECT * FROM `users` WHERE user_email = '$email'";
     $data1 = mysqli_query($conn , $query);


     if($flag){
          if(!(mysqli_num_rows($data1))){

          $password = md5($_POST[ 'password']);
          $query = "INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`, `user_phone` ,`user_dob`, `user_gender`,`user_type`) VALUES (NULL, '$name', '$email', '$password', '$phone','$dob','$gender', 'user')";
          $data = mysqli_query( $conn, $query );
          echo"<script> alert('Successful')</script>";
          // header("location:login.php");  
          }
          else{
               echo"<script> alert('email already registered')</script>";
          }
     }


     }
     
?>