 <?php
  session_start();
  include_once 'conn.php';
  $query = "SELECT * FROM `users`";
  $data = mysqli_query($conn, $query);
  $arr = mysqli_fetch_array($data);
 


  if (isset($_POST['login'])) {
    extract($_POST);
    // msg_variable**************
    $flag = true;
    // $msg_email = "";
    // $msg_password = "";

    // check for empty email & password**********************
    // if ($email == "") {
    //   @$msg_email .= 'Email empty!';
    //   $flag = false;
    // }

    // if ($password == "") {
    //   @$msg_password .= 'password is empty';
    //   $flag = false;
    // }

    // query 
    if ($flag) {
      $query1 = "SELECT `user_email` FROM `users` WHERE `user_email`='$email'";
      $data1 = mysqli_query($conn, $query1);
      $fetch_data1 = mysqli_fetch_row($data1);

      if (mysqli_num_rows($data1)) {
        $password = md5($_POST['password']);
        $query2 = "SELECT * FROM `users` WHERE `user_email`='$email' AND `user_password`='$password'";
        $data2 = mysqli_query($conn, $query2);
        $fetch_data2 = mysqli_fetch_array($data2);

        @$_SESSION['id'] = $fetch_data2['user_id'];
        @$_SESSION['name'] = $fetch_data2['user_name'];
        @$_SESSION['email'] = $fetch_data2['user_email'];
        @$_SESSION['password'] = $fetch_data2['user_password'];
        @$_SESSION['dob'] = $fetch_data2['user_dob'];
        @$_SESSION['gender'] = $fetch_data2['user_gender'];
        @$_SESSION['phone'] = $fetch_data2['user_phone'];
        @$_SESSION['user_type'] = $fetch_data2['user_type'];

        if (mysqli_num_rows($data2)) {
          echo "<script>alert('Login sucessfull');</script>";
          header("location:dashboard_upper.php");
        } 
        else {
          echo "<script>alert('Password not matched!!');</script>";
        }
      } 
      else {
        echo "<script>alert('Email not registered!!');</script>";
      }
    }
  }

  ?>


 <!DOCTYPE html>
 <html lang="en">

 <head>

   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>

 </head>
 <style>
   .divider:after,
   .divider:before {
     content: "";
     flex: 1;
     height: 1px;
     background: #eee;
   }

   .h-custom {
     height: calc(100% - 73px);
   }

   @media (max-width: 450px) {
     .h-custom {
       height: 100%;
     }
   }

   .con2 {
     height: 580px;
     width: 500px;
     border: 2px solid white;
     background-color: #f0f1f4;
     margin-top: 20px;

   }

   #unique {
     color: rgb(228, 215, 215);
     font-weight: 400;
     background-color: brown;
   }
 </style>


 <body style="background-color: white;">

   <!-- nav bar -->
   <nav class="navbar navbar-expand-lg navbar-dark bg-primary nav1">
     <div class="container-fluid">
       <a class="navbar-brand" style="font-size:30px;font-weight:20px;color:white">Survey System</a>
       <button class="btn btn-outline-success " type="submit" style="margin-left: 25cm; color: white; background-color:white;"> <a href="#">Signup</a></button>

     </div>
     </div>
   </nav>

   <!-- form -->
   <form class="d-flex" onsubmit="return validateform();" method="post">
     <div class="container con h-auto">
       <article class="card-body mx-auto mt-5" style="max-width:400px;max-height:400px;border:1px solid black">
         <h4 class="card-title mt-3 text-center">Login into Account</h4>

         <div class="form-group input-group">
         </div>
         <div class="form-group input-group">
           <div class="input-group-prepend">
             <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
           </div>
           <input type="email" id="emailid" style="width:80%" class="form-control" name="email" placeholder="Email address" type="text">
           <span id="emailprompt" class="text-danger"><?php echo @$msg_email ?></span><br>
         </div>


         <div class="form-group input-group">
           <div class="input-group-prepend">
             <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
           </div>
           <input class="form-control" id="passid" style="width:80%" name="password" placeholder="Enter password" type="password">
           <span id="passprompt" class="text-danger"><?php echo @$msg_password ?></span><br>
         </div>
         <!-- <span id="passval"></span> -->

         <div class="form-group">
           <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
         </div>

   </form>
   </div>

    <script src="../javascript_validation/login.js"></script>
 </body>

 </html>