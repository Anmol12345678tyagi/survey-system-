<?php
include_once 'conn.php';
include_once 'dashboard_upper.php';

if (isset($_POST['submit'])) {

  extract($_POST);
  //   //php validation

  //   $flag = true;


  // $name = $_POST['name'];
  // @$cat = $_POST['drop_cat'];
  // $desc = $_POST['desc'];
  // $created_date = $_POST['created_date'];

  //   //variable****************************

  //   // $msg_name = "";
  //   // $msg_cat = "";
  //   // $msg_desc = "";
  //   // //  $msg_created_by = "";
  //   // $msg_created_date = "";


  //   //pattern*****************************
  //   // $rel_name1 = '/[0-9]/';
  //   // $rel_name2 = '/[~`!@#$%^&*()\[\]\\.,;:@"\-\\_+={}<>?]/';
  //   // // $rel_email = '/^[A-z0-9_.-]+[@][a-z]+[.][a-z]{2,3}$/';  
  //   // $relph = '/^\d{10}$/';
  //   // $rel_pass1 = '/[A-Z]/';
  //   // $rel_pass2 = '/[a-z]/';
  //   // $rel_pass3 = '/[0-9]/';
  //   // $rel_pass4 = '/[~`!@#$%^&*()\[\]\\.,;:\s@"\-\\_+={}<>?]/';


  //   // //name********************************
  //   // if ($name == "") {
  //   //   $msg_name .= "name field is empty <br>";
  //   //   $flag = false;
  //   // } else {
  //   //   if (preg_match($rel_name1, $name)) {
  //   //     $msg_name .= "name should not contain numbers <br>";
  //   //     $flag = false;
  //   //   }
  //   //   if (preg_match($rel_name2, $name)) {
  //   //     $msg_name .= "name should not contain Special Character <br>";
  //   //     $flag = false;
  //   //   }
  //   // }
  //   // //cat*************************************
  //   // if ($cat == "") {
  //   //   $msg_cat .= "empty categorie <br>";
  //   //   $flag = false;
  //   // }
  //   // //created date********************************
  //   // if ($created_date == "") {
  //   //   $msg_created_date .= 'empty date';
  //   //   $flag = false;
  //   // } 
  //   // //desc*************************************
  //   // if ($desc == "") {
  //   //   $msg_desc .= "empty desc";
  //   //   $flag = false;
  //   // }

  $date = date('Y-m-d');
  $s_created_by = $_SESSION['id'];


  $query = "INSERT INTO `survey`(`survey_name`, `Survey_description`, `Survey_Category`,`Survey_Start_Date`,`Survey_End_Date`,Survey_Created_Date,`Survey_Created_By`) VALUES ('$name','$desc','$drop_cat','$start_date','$End_date','$date','$s_created_by')";
  $data = mysqli_query($conn, $query); ?>
 <script> location.replace("survey_list.php") </script>
<?php }

include_once 'header.php';
?>

<!--  -->
<style>
  @media (min-width: 1025px) {
    .h-custom {
      height: 100vh !important;
    }
  }

  .span_color {
    color: red;
  }

  .margin_left {
    margin-left: 80px;
  }
</style>

<!-- back button -->
<div class="row col-1 ms-1 mt-1">
  <a href="survey_list.php" style="width:100%;margin-left:0px"><i class="fa-solid fa-angles-left"></i></a>
</div>

<div class="container py-5 h-100">
  <div class="row d-flex justify-content-center align-items-center h-100">
    <div class="col-lg-8 col-xl-8">
      <div class="card rounded-3" style="border:inset ">
        <div class="card-body p-4 p-md-5" style="border:1px solid blue">
          <h3 class="pb-2 pb-md-0 px-md-2" style="padding-left:5px;">Name Your Survey</h3>
          <hr style="border:1px solid blue ">
          <div class="mt-5" style="">
            <form class="px-md-2" onsubmit="return validation()" method="post">

              <div class="form-outline mb-4">
                <label class="form-label" for="form3Example1q">Survey Name</label><br>
                <input type="text" id="name" name="name" class="form-control" placeholder="name" />
                <span class="span_color" id="nameprompt"><?php echo @$msg_name ?></span>
              </div>

              <div class="form-outline mb-4">
                <label class="form-label" for="form3Example1q">Survey Category</label><br>
                <div class=" col-12">
                  <select class="form-select" aria-label="Default select example" name="drop_cat" id="drop1">
                    <option value="">Category</option>
                    <option value="Education">Education</option>
                    <option value="Finance">Finance</option>
                    <option value="Marketing">Marketing</option>
                  </select>
                </div>
                <span class="span_color" id="catprompt"><?php echo @$msg_cat ?></span>
              </div>

              <div class="form-outline mb-4">
                <label class="form-label" for="form3Example1q">Survey description</label><br>
                <textarea type="text" class="form-control p-5" id="desc" name="desc" placeholder="//description" class="form-control"></textarea><br>
                <span class="span_color" id="descprompt"><?php echo @$msg_desc ?></span>
              </div>

              <!-- <div class="form-outline mb-4">
                <label class="form-label" for="form3Example1q">Survey Created By</label><br>
                <input type="text" class="form-control " id="form3Example1q" name="created_by" class="form-control">
                <span class="span_color" id="name_prompt"><?php echo @$msg_created_by ?></span>
              </div> -->

              <div class="form-outline mb-4">
                <label class="form-label" for="form3Example1q">Survey Start Date</label><br>
                <input type="date" min="<?php echo date("Y-m-d") ?>" class="form-control" id="date" name="start_date" class="form-control">
                <span class="span_color" id="dateprompt"><?php echo @$msg_created_date ?></span>
              </div>

              <div class="form-outline mb-4">
                <label class="form-label" for="form3Example1q">Survey End Date</label><br>
                <input type="date" min="<?php echo date("Y-m-d") ?>" class="form-control" id="date1" name="End_date" class="form-control">
                <span class="span_color" id="dateprompt1"><?php echo @$msg_End_date ?></span>
              </div>



              <button type="submit" name="submit" class="btn btn-success btn-lg mb-1">Create Survey</button>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="../javascript_validation/survey_desc.js"></script>

<?php
include_once 'footer.php';
include_once 'dashboard_lower.php';
?>