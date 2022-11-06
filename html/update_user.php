<?php
include_once 'conn.php';
$id = $_GET['id'];

if (isset($_POST['submit1'])) {
  extract($_POST);

  if ($user_type != "") {
    $query = "UPDATE `users` SET `user_type`='$user_type' WHERE `user_id` = '$id'";
    $data  = mysqli_query($conn, $query);
    echo "<script>alert('Update sucessfull')</script>";
    header("location:user_table.php");
  } else {
    header("location:user_table.php");
  }
  
}
// include_once 'update.php';
include_once 'header.php';
include_once 'dashboard_upper.php';

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

<?php 

$query1 = "SELECT * FROM `users` WHERE `user_id`='$id'";
$data1 = mysqli_query($conn, $query1);
if (mysqli_num_rows($data1) > 0) {
  while ($arr = mysqli_fetch_array($data1)) {
     $name1 = $arr[1];
    $email1 = $arr[2];
    $password1 = $arr[3];
    $dob1 = $arr[4];
    $gender1 = $arr[5];
    $phone1 = $arr[6];
    $role = $arr['user_type'];
    
  }
}

?>


<div class="container py-5 h-100">
  <div class="row d-flex justify-content-center align-items-center h-100">
    <div class="col-lg-8 col-xl-8">
      <div class="card rounded-3" style="border:inset">
        <div class="card-body p-4 p-md-5" style="border:1px solid blue ">
          <h3 class="mb-2 pb-2 pb-md-0 mb-md-2 px-md-2">Update User</h3>
          <hr style="border:1px solid blue ">
          <div class="mt-5" style="border:1px ">
            <form class="px-md-2 mt-4" method="post">

              <div class="form-outline mb-4">
                <label class="form-label" for="form3Example1q">Name</label><br>
                <input type="text" id="form3Example1q" name="name" class="form-control" value="<?php echo $name1 ?>" disabled />
                <!-- <span class="span_color" id="name_prompt"></span> -->

              </div>

              <div class="form-outline mb-4">
                <label class="form-label" for="form3Example1q">Email</label><br>
                <input type="email" id="form3Example1q" name="email" value="<?php echo $email1 ?>" class="form-control" disabled />
                <!-- <span class="span_color" id="email_prompt"><?php echo @$msg_email ?></span> -->
              </div>

              <div class="row">
                <div class="col mb-4">

                  <!-- <div class="form-outline datepicker"> -->
                  <label for="exampleDatepicker1" class="form-label">date of birth</label><br>
                  <input type="email" id="form3Example1q" name="email" value="<?php echo $dob1 ?>" class="form-control" disabled />
                  <!-- <span class="span_color" id="dob_prompt"><?php echo @$msg_dob ?></span> -->
                </div>
              </div>

              <div class="form-outline mb-4">
                <label class="form-label" for="form3Example1q">Gender</label><br>
                <input type="text" id="form3Example1q" name="name" class="form-control" value="<?php echo $gender1 ?>" disabled />
                <!-- <span class="span_color" id="gender_prompt"><?php echo @$msg_gender ?></span> -->
              </div>


              <div class="form-outline mb-4">
                <label class="form-label" for="form3Example1q">phone number</label><br>
                <input type="text" id="form3Example1q" name="phone" value="<?php echo $phone1 ?>" class="form-control" disabled />
                <!-- <span class="span_color" id="phone_prompt"><?php echo @$msg_phone ?></span> -->
              </div>

              <div class="form-outline mb-4">
                <label class="form-label" for="form3Example1q">Role</label>
                <div class="row col-12  py-2" style="margin-left:1px">
                  <select name="user_type" style="padding:7px;" id="">
                    <option value="">select user type</option>
                    <option value="user" <?php if($role == "user"){ echo "selected" ;} ?>>user</option>
                    <option value="admin" <?php if($role == "admin"){ echo "selected" ;} ?>>admin</option>
                  </select>
                </div>
                <!-- <input type="text"  id="form3Example1q" name="phone" value="<?php echo $get_role ?>" class="form-control" /> -->
                <!-- <span class="span_color" id="phone_prompt"></span> -->
              </div>


              <button type="submit" name="submit1" class="btn btn-success btn-lg mb-1">Update</button>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<?php
include_once 'dashboard_lower.php';
include_once 'footer.php';
?>