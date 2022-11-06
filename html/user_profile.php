<?php
// session_start();
include_once 'header.php';
include_once 'dashboard_upper.php';
include_once 'conn.php';
?>
<style>
    .r1{border:1px solid black}
    .r2{border:1px solid red}
    .r3{border:1px solid green}
    .r4{border:1px solid yellow}
    
</style>
<!-- back button -->
<div class="row col-1 ms-1 mt-1">
    <a href="survey_list.php" style="width:100%;margin-left:0px"><i class="fa-solid fa-angles-left"></i></a>
  </div>
<!-- survey description -->
    <div class="container ms-0 col-8 m-5 ms-5 r1" style="box-shadow: 10px 10px;border:inset;">
        <div class="row" style="border:1px solid blue;border-top:5px solid blue">
            <div class="col-12 p-3">

                <div class="row">
                    <div class="col-md-3 pt-1 pe-0"><p>Name :<p></div>
                        <div class="col-md-9 ps-0">
                            <input type="text" class="form-control" style="border-left:5px solid blue;" value="<?php echo $_SESSION['name']?>"  aria-label="Username" aria-describedby="basic-addon1" >
                        </div>
                    </div>

                    <div class="row">
                    <div class="col-md-3 pt-1 pe-0"><p>Email :<p></div>
                        <div class="col-md-9 ps-0">
                            <input type="text" class="form-control" style="border-left:5px solid blue;" value="<?php echo $_SESSION['email']?>"  aria-label="Username" aria-describedby="basic-addon1" disabled>
                        </div>
                    </div>

                    
                    <!-- <div class="row">
                    <div class="col-md-3 pt-1 pe-0"><p>Password :<p></div>
                        <div class="col-md-9 ps-0">
                            <input type="text" class="form-control" style="border-left:5px solid blue;" value="<?php echo $_SESSION['password']?>"  aria-label="Username" aria-describedby="basic-addon1" >
                        </div>
                    </div> -->

                    
                    <div class="row">
                    <div class="col-md-3 pt-1 pe-0"><p>Date of Birth :<p></div>
                        <div class="col-md-9 ps-0">
                            <input type="text" class="form-control" style="border-left:5px solid blue;" value="<?php echo $_SESSION['dob']?>"  aria-label="Username" aria-describedby="basic-addon1" >
                        </div>
                    </div>

                    
                    <div class="row">
                    <div class="col-md-3 pt-1 pe-0"><p>Gender :<p></div>
                        <div class="col-md-9 ps-0">
                            <input type="text" class="form-control" style="border-left:5px solid blue;" value="<?php echo $_SESSION['gender']?>"  aria-label="Username" aria-describedby="basic-addon1" >
                        </div>
                    </div>

                    
                    <div class="row">
                    <div class="col-md-3 pt-1 pe-0"><p>Phone :<p></div>
                        <div class="col-md-9 ps-0">
                            <input type="text" class="form-control" style="border-left:5px solid blue;" value="<?php echo $_SESSION['phone']?>"  aria-label="Username" aria-describedby="basic-addon1" >
                        </div>
                    </div>

                    
                    <div class="row">
                    <div class="col-md-3 pt-1 pe-0"><p>User Type :<p></div>
                        <div class="col-md-9 ps-0">
                            <input type="text" class="form-control" style="border-left:5px solid blue;" value="<?php echo $_SESSION['user_type']?>"  aria-label="Username" aria-describedby="basic-addon1" disabled>
                        </div>
                    </div>

                    <!-- <div class="row">
                    <div class="col-md-3 pt-1 pe-0"><p> :<p></div>
                        <div class="col-md-9 ps-0">
                        <textarea class="form-control py-4"  style="border-left:5px solid blue;height:150px" id="floatingTextarea2" disabled><?php echo $s_dec?></textarea>
                        </div>
                    </div> -->


     </div>
        </div>
    </div>


    

<?php
include_once 'dashboard_lower.php';
include_once 'footer.php';
?>