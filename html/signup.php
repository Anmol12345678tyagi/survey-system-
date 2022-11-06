<?php
require_once '../php_val/signval.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/333font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <title>Document</title>
</head>
<style>
        .divider-text {
                position: relative;
                text-align: center;
                margin-top: 15px;
                margin-bottom: 15px;
        }

        .divider-text span {
                padding: 7px;
                font-size: 12px;
                position: relative;
                z-index: 2;
        }

        .divider-text:after {
                content: "";
                position: absolute;
                width: 100%;
                border-bottom: 1px solid #ddd;
                top: 55%;
                left: 0;
                z-index: 1;
        }

        .btn-facebook {
                background-color: #405D9D;
                color: #fff;
        }

        .btn-twitter {
                background-color: #42AEEC;
                color: #fff;
        }

        .con {
                border: 1px solid black;
                background-color: #f0f1f4;
                /* height: 600px; */
                width: 500px;
                margin-top: 3rem;
        }
</style>

<body style="background-color:white">
        <!-- nav bar -->
        <nav class='navbar navbar-expand-lg navbar-dark bg-primary nav1'>
                <div class='container-fluid'>
                        <a class='navbar-brand' style="font-size:30px;font-weight:20px;color:white;">Survey System</a>
                        <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
                                <span class='navbar-toggler-icon'></span>
                        </button>
                </div>
        </nav>

        <!-- form -->
        <form class='d-flex' onsubmit="return validatesignup();" method='post'>
                <div class='container con'>
                        <article class='card-body mx-auto'>
                                <h4 class='card-title mt-3 text-center'>Create Account</h4>
                                <p class='text-center'>Get started with your free account</p>
                                <!-- name -->
                                <div class='form-group input-group'>
                                        <div class='input-group-prepend'>
                                                <span class='input-group-text ;'> <i class='fa fa-user' style='font-size:24px'></i> </span>
                                        </div>
                                        <input name='name' style="width:80%" class='form-control' id="name" placeholder='Full name' type='text'>
                                        <span class="text-danger" id="nameprompt"><?php echo @$msg_name; ?></span>
                                </div>

                                <!-- email -->
                                <div class='form-group input-group'>
                                        <div class='input-group-prepend'>
                                                <span class='input-group-text'> <i class='fa fa-envelope'></i> </span>
                                        </div>
                                        <input name='email' style="width:80%" id="email_ID" class='form-control' placeholder='Email address' type='text'>
                                        <span id="emailprompt" class="text-danger"><?php echo @$msg_email; ?></span>
                                </div>

                                <!-- password -->
                                <div class='form-group input-group'>
                                        <div class='input-group-prepend'>
                                                <span class='input-group-text'> <i class='fa fa-lock'></i> </span>
                                        </div>
                                        <input class='form-control' style="width:80%" name='password' id="passid" placeholder='Create password' type='password'>
                                        <span id="passprompt" class="text-danger"><?php echo @$msg_password; ?></span>
                                </div>

                                <!--confirm password  -->
                                <div class='form-group input-group'>
                                        <div class='input-group-prepend'>
                                                <span class='input-group-text'> <i class='fa fa-lock'></i> </span>
                                        </div>
                                        <input class='form-control' style="width:80%" name='conf_password' id="confpassid" placeholder='Repeat password' type='password'>
                                        <span id="con_pass_prompt" class="text-danger"><?php echo @$msg_con_password; ?></span>
                                </div>


                                <!-- dob -->
                                <div class='form-group input-group'>
                                        <div class='input-group-prepend'>
                                                <span class='input-group-text'><i class="fa-solid fa-calendar-days"></i> </span>
                                        </div>
                                        <input name='dob' style="width:80%" type="date" id="dob_phone" class='form-control'>
                                        <span id="dobprompt" class="text-danger"><?php echo @$msg_dob; ?></span>
                                </div>

                                <!-- gender -->

                                <!-- <div class='form-group input-group'>
                                        <div class='input-group-prepend'>
                                                <span class='input-group-text'><i class="fa-solid fa-users"></i></span>
                                        </div>
                                        <input id="id_phone" class='form-control' placeholder='Gender' disabled>
                                </div>
                                <div class="ms-2  mb-1">
                                        <input type="radio" name="radio" value="male" class="me-3"><label class="me-3" for="">Male</label>
                                        <input type="radio" name="radio" value="female" class="me-3"><label for="">Female</label>
                                </div>
                                <span id="genderprompt" class="text-danger"><?php echo @$msg_gender; ?></span> -->


                                <div class='form-group input-group'>
                                        <div class='input-group-prepend'>
                                                <span class='input-group-text'><i class="fa-solid fa-calendar-days"></i> </span>
                                        </div>
                                        <select class="form-select" aria-label="Default select example" name="drop_gender" id="drop1">
                                                <option value="">Gender</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Other</option>
                                        </select>
                                        <span id="genderprompt" class="text-danger"><?php echo @$msg_gender; ?></span>
                                </div>


                                <!-- phone -->
                                <div class='form-group input-group'>
                                        <div class='input-group-prepend'>
                                                <span class='input-group-text'> <i class='fa fa-phone '></i> </span>
                                        </div>
                                        <input name='Phone' style="width:80%" id="id_phone" class='form-control' placeholder='Phone Number'>
                                        <span id="phoneprompt" class="text-danger"><?php echo @$msg_phone; ?></span>
                                </div>

                                <div class='form-group'>
                                        <button type='submit' name='submit' class='btn btn-primary btn-block'>
                                                Create Account </button>

                                </div>
                                <p class='text-center'>Have an account?<a href="login.php"><button type="button" class="btn btn-primary">Login</button></a></p>
                        </article>
                </div>
        </form>


        <!-- <script src = '//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
<script src = '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'></script>
<script src = 'js/bootstrap.js'></script>
</html>          -->
        <!-- <script src="javascript/sign.js"></script> -->

</body>

</html>