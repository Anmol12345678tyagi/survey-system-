<?php
include_once 'conn.php';

$id=$_GET['id'];



if(isset($_POST['submit'])){
    extract($_POST);
    $query = "UPDATE `survey` SET `survey_name`='$name',`Survey_description`='$desc',`Survey_Category`='$cat',`Survey_Start_Date`='$start_date',`Survey_End_Date`='$created_End_date' WHERE `survey_id`='$id'";
    $data = mysqli_query($conn,$query);
    header("location:survey_list.php");
}

if(isset($_POST['cancel'])){
  header("location:survey_list.php");
}

$query = "SELECT * FROM `survey` WHERE Survey_id = $id ";
$data = mysqli_query($conn, $query);
$res = mysqli_fetch_array($data);

include_once 'header.php';
include_once 'dashboard_upper.php';
?>

<!--  -->
<style>
@media (min-width: 1025px) {
.h-custom {
height: 100vh !important;
}
}
.span_color{
  color:red;
}
.margin_left{
    margin-left:80px;
}
</style>
<!-- back button -->
<div class="row col-1 ms-1 mt-1">
    <a href="survey_list.php" style="width:100%;margin-left:0px"><i class="fa-solid fa-angles-left"></i></a>
  </div>  


  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-lg-8 col-xl-8">
        <div class="card rounded-3" style="border:inset">
          <div class="card-body p-4 p-md-5" style="border:1px solid blue ">
            <h3 class="pb-2 pb-md-0 px-md-2 "  style="padding-left:5px;">Update Survey</h3>
            <hr style="border:1px solid blue ">
            <div class="mt-5" style="border:1px ">
                <form class="px-md-2" method="post">

                  <div class="form-outline mb-4">
                    <label class="form-label" for="form3Example1q">Survey Name</label><br>
                    <input type="text" id="form3Example1q" name="name" value="<?php echo $res['survey_name']?>" class="form-control" />
                  </div>
                  
                  <div class="form-outline mb-4">
              <label class="form-label" for="form3Example1q">Survey Category</label><br>
                <div class=" col-12">
                  <select class="form-select" aria-label="Default select example" name="cat" id="drop1">
                    <!-- <option value="">Category</option> -->
                    <option value="Education" <?php if ($res['Survey_Category'] == "Education") {
                                              echo "selected";
                                            } ?> >Education </option>
                    <option value="Finance" <?php if ($res['Survey_Category'] == "Finance") {
                                              echo "selected";
                                            } ?>  >Finance</option>
                    <option value="Marketing" <?php if ($res['Survey_Category'] == "Marketing") {
                                              echo "selected";
                                            } ?>  >Marketing</option>
                  </select>
                </div>
              </div>

                  <div class="form-outline mb-4">
                    <label class="form-label" for="form3Example1q">Survey description</label><br>
                    <textarea type="text" class="form-control p-5" id="form3Example1q"  name="desc" class="form-control"><?php echo $res['Survey_description']?></textarea><br>
                  </div>

                  <div class="form-outline mb-4">
                    <label class="form-label" for="form3Example1q">Survey Start Date</label><br>
                    <input type="date"  class="form-control" id="form3Example1q" value="<?php echo date('Y-m-d',strtotime($res['Survey_Start_Date'])) ?>" name="start_date" class="form-control">
                  </div>

                  <div class="form-outline mb-4">
                    <label class="form-label" for="form3Example1q">Survey End Date</label><br>
                    <input type="date"  class="form-control" id="form3Example1q" value="<?php echo date('Y-m-d',strtotime($res['Survey_End_Date'])) ?>" name="created_End_date" class="form-control">
                  </div>
                  
                  
                  <button type="submit" name="submit" class="btn btn-success btn-lg mb-1">Update Survey</button>
                  <button type="submit" name="cancel" class="btn btn-danger btn-lg mb-1">cancel</button>

                </form>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php
// include_once '../connection.php';

// $conn = mysqli_connect('localhost','root','','survey');

// if(isset($_POST['submit'])){
//   $name = $_POST['name'];
//   // $title = $_POST['title'];
//   $cat = $_POST['cat'];
//   $desc = $_POST['desc'];
//   // $created_by = $_POST['created_by'];
//   $created_date = $_POST['created_date'];

//   if($name == "" && $cat == "" && $desc == "" && $created_date == "" && $created_date == ""){
//     echo "<script>alert('fill update field')</script>";
//   }
//   else{
//     $query = "INSERT INTO `survey`(`survey_name`, `Survey_description`, `Survey_Category`,`Survey_Created_Date`) VALUES ('$name','$desc','$cat','$created_date')";
//     $data = mysqli_query($conn,$query);
//     echo "<script>alert('sucessfull')</script>";

//   }

// }
?>

<?php
include_once 'footer.php';
include_once 'dashboard_lower.php';
?>