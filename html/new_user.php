<?php
include_once 'conn.php';

// insert into ueers table
if (isset($_POST['submit'])) {
  extract($_POST);

  $password = md5($_POST['password']);
  $query = "INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`, `user_phone` ,`user_dob`, `user_gender`,`user_type`) VALUES (NULL, '$name', '$email', '$password', '$phone','$dob','$drop_gender', 'user')";
  $data = mysqli_query($conn, $query);
  echo "<script> alert('user added Successful')</script>";
  header("location:user_table.php");  
}


include_once 'header.php';
include_once 'dashboard_upper.php';
// require_once '../php_val/signval.php'; 

?>
<style> 
  @media (min-width: 1025px) {
    .h-custom {
      height: 100vh !important;
    }
  }

  .span_color {
    color: red;
  }
</style>

<div class="container py-5 h-100">
  <div class="row d-flex justify-content-center align-items-center h-100">
    <div class="col-lg-8 col-xl-8">
      <div class="card rounded-3" style="border:inset">
        <div class="card-body p-4 p-md-5" style="border:1px solid blue ">
          <h3 class=" pb-2 pb-md-0  px-md-2">New User Creation</h3>
          <hr style="border:1px solid blue ">
          <div class="mt-5" style="border:1px ">
            <form class="px-md-2" onsubmit="return validate()" method="post">

              <div class="form-outline mb-4">
                <label class="form-label" for="form3Example1q">Name</label><br>
                <input type="text" id="name" name="name" class="form-control" />
                <span class="span_color" id="nameprompt"><?php echo @$msg_name ?></span>

              </div>

              <div class="form-outline mb-4">
                <label class="form-label" for="form3Example1q">Email</label><br>
                <input type="text" id="email" name="email" class="form-control" />
                <span class="span_color" id="emailprompt"><?php echo @$msg_email ?></span>
              </div>


              <div class="form-outline mb-4">
                <label class="form-label" for="form3Example1q">password</label><br>
                <input type="text" id="password" name="password" class="form-control" type="password" />
                <span class="span_color" id="passwordprompt"><?php echo @$msg_password ?></span>
              </div>

              <div class="form-outline mb-4">
                <label class="form-label" for="form3Example1q">Confirm password</label><br>
                <input type="text" id="conf_password" name="conf_password" class="form-control" type="password" />
                <span class="span_color" id="con_passwordprompt"><?php echo @$msg_con_password ?></span>
              </div>

              <div class="form-outline mb-4">
                <label class="form-label" for="form3Example1q">Date of birth</label><br>
                <input type="date" id="dob" name="dob" class="form-control" />
                <span class="span_color" id="dobprompt"><?php echo @$msg_dob ?></span>
              </div>

              <div class="form-outline mb-4">
                <label for="exampleDatepicker1" class="form-label">Gender</label><br>
                <div class=" col-12">
                  <select class="form-select" aria-label="Default select example" name="drop_gender" id="drop1">
                    <option value="">Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                  </select>
                </div>
                <span class="span_color" id="genderprompt"><?php echo @$msg_gender ?></span>
              </div>

              <div class="form-outline mb-4">
                <label class="form-label" for="form3Example1q">phone</label><br>
                <input type="rel" id="id_phone" name="phone" pattern="[0-9]{10}" class="form-control" placeholder='123-456-789-0' />
                <span class="span_color" id="phoneprompt"><?php echo @$msg_con_password ?></span>
              </div>

          </div>
          <button type="submit" name="submit" class="btn btn-success btn-lg mb-1">Submit</button>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="../javascript_validation/new_user.js"></script>

<?php
include_once 'dashboard_lower.php';
include_once 'footer.php';
?>